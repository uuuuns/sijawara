<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class SsoService
{
    protected Client $client;
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.sso.url', env('SSO_URL', 'http://localhost:9000')), '/') . '/';

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Login to SSO server
     */
    public function login(string $username, string $password): array
    {
        try {
            $response = $this->client->post('api/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['data']['access_token']) && isset($data['data']['user'])) {
                $cacheKey = 'sso_user_' . hash('sha256', $data['data']['access_token']);
                \Illuminate\Support\Facades\Cache::put($cacheKey, [
                    'success' => true,
                    'data' => $data['data']['user']
                ], now()->addMinutes(15));
            }

            return [
                'success' => true,
                'data' => $data,
            ];
        } catch (RequestException $e) {
            $body = [];
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $e->getMessage(),
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Register new user in SSO server
     */
    public function register(array $userData): array
    {
        return $this->createUser($userData);
    }

    /**
     * Create/Register new user in SSO server (for auto-sync when creating user locally)
     * 
     * @param array $userData [name, email, nik, phone, password, user_type, legacy_sijawara_id, must_change_password]
     */
    public function createUser(array $userData): array
    {
        try {
            $payload = [
                'name' => $userData['name'],
                'email' => $userData['email'] ?? null,
                'nik' => $userData['nik'] ?? null,
                'phone' => $userData['phone'] ?? null,
                'password' => $userData['password'],
                'user_type' => $userData['user_type'] ?? 'umum',
                'legacy_sijawara_id' => $userData['legacy_sijawara_id'] ?? null,
            ];

            if (isset($userData['must_change_password'])) {
                $payload['must_change_password'] = $userData['must_change_password'];
            }

            $response = $this->client->post('api/register', [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => $data['data'] ?? $data,
            ];
        } catch (RequestException $e) {
            $body = [];
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $e->getMessage(),
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update existing user in SSO server (server-to-server via target_email)
     * 
     * @param string $targetEmail
     * @param array $profileData [name, email, nik, phone, photo, password]
     */
    public function updateUser(string $targetEmail, array $profileData): array
    {
        try {
            $payload = array_merge(['target_email' => $targetEmail], $profileData);
            $response = $this->client->post('api/update-user', [
                'json' => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => $data,
            ];
        } catch (RequestException $e) {
            $body = [];
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $e->getMessage(),
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get user info from SSO server
     */
    public function getUser(string $accessToken, bool $skipCache = false): array
    {
        $cacheKey = 'sso_user_' . hash('sha256', $accessToken);
        if (!$skipCache) {
            $cached = \Illuminate\Support\Facades\Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        try {
            $response = $this->client->get('api/user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json'
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $result = [
                'success' => true,
                'data' => $data['data'],
            ];

            \Illuminate\Support\Facades\Cache::put($cacheKey, $result, now()->addMinutes(15));

            return $result;
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Logout from SSO server
     */
    public function logout(string $accessToken): array
    {
        $cacheKey = 'sso_user_' . hash('sha256', $accessToken);
        \Illuminate\Support\Facades\Cache::forget($cacheKey);

        try {
            $this->client->post('api/logout', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            return ['success' => true];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Change password on SSO server
     */
    public function changePassword(string $accessToken, string $currentPassword, string $newPassword): array
    {
        try {
            $this->client->post('api/change-password', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => [
                    'current_password' => $currentPassword,
                    'new_password' => $newPassword,
                    'new_password_confirmation' => $newPassword,
                ],
            ]);

            return ['success' => true];
        } catch (RequestException $e) {
            $body = [];
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $e->getMessage(),
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update legacy app ID on the SSO user
     */
    public function updateLegacyId(string $accessToken, string $field, string $value): array
    {
        try {
            $response = $this->client->post('api/update-legacy-id', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => [
                    'field' => $field,
                    'value' => $value,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => $data,
            ];
        } catch (RequestException $e) {
            $body = [];
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $e->getMessage(),
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update user profile on the SSO server
     */
    public function updateProfile(string $accessToken, array $profileData): array
    {
        try {
            $response = $this->client->post('api/update-profile', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => $profileData,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => $data,
            ];
        } catch (RequestException $e) {
            $body = [];
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            return [
                'success' => false,
                'message' => $body['message'] ?? $e->getMessage(),
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Log user activity to SSO server
     */
    public function logActivity(string $accessToken, string $action = 'access_app', ?string $description = null, ?string $ip = null, ?string $userAgent = null): array
    {
        try {
            $response = $this->client->post('api/log-activity', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => [
                    'app_code'    => 'sijawara',
                    'app_name'    => 'SIJAWARA+',
                    'action'      => $action,
                    'description' => $description ?: 'User mengakses aplikasi SIJAWARA+',
                    'ip_address'  => $ip ?: request()->ip(),
                    'user_agent'  => $userAgent ?: request()->userAgent(),
                ],
            ]);

            return [
                'success' => true,
                'data'    => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
