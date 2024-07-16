<?= $ScriptMidtrans ?>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .page-header-custom {
        background: url('<?= asset('assets_new') ?>/images/bg/illustration-bg.png') 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: initial;
    }
</style>

<section class="page-header page-header-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 pe-3">
                <div class="title-block">
                    <h1>Konfirmasi Pembayaran</h1>
                    <ul class="header-bradcrumb justify-content-center">
                        <li><a href="{{ url('') }}">Beranda</a></li>
                        <li class="active" aria-current="page">Konfirmasi Pembayaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="woocommerce single page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <form id="form-purchase" method="POST" action="<?= url('check_payment_status') ?>">
                    @csrf
                    <div class="woocommerce-cart">
                        <div class="woocommerce-cart-form">
                            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents table-responsive w-100" cellspacing="0">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col" width="43%">Produk</th>
                                        <th scope="col" width="18%"></th>
                                        <th scope="col" width="18%"></th>
                                        <th scope="col" width="18%">Harga</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                                    <?php
                                    $TotalBayar = 0;
                                    foreach ($order[0] as $item) :
                                        $TotalBayar += $item->PRICE_ORDER;
                                    ?>
                                        <tr class="">
                                            <td class="flex-row d-flex align-items-center">
                                                <img src="<?= (!empty($item->IMAGE_ACTIVITY)) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK; ?>" class="d-block img-fluid rounded-2 w-25">
                                                <span class="ms-2"><?= (!empty($item->TITLE_ACTIVITY)) ? $item->TITLE_ACTIVITY : $item->JUDUL; ?></span>
                                            </td>
                                            <td>
                                            </td>
                                            <td></td>
                                            <td class="product-subtotal"><?= "Rp " . number_format($item->PRICE_ORDER, 2, ',', '.') ?></td>
                                        </tr>
                                        <input type="hidden" name="tot_bayar" value="<?= $TotalBayar ?>">
                                        <input type="hidden" name="id_activity[]" value="<?= $item->ID_PRODUCT ?>">
                                        <input type="hidden" name="price[]" value="<?= $item->PRICE_ORDER ?>">
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column-reverse">
                        <table class="table table-borderless">
                            <thead>
                                <?php if (!empty($promo['AMMOUNT'])) { ?>
                                    <tr class="fw-semibold">
                                        <td scope="col" width="61%"></td>
                                        <td class="text-left product-subtotal" scope="col" width="18%">Sub Total</td>
                                        <td scope="col" width="18%">
                                            <s><?= "Rp " . number_format($TotalBayar, 2, ',', '.') ?></s>
                                        </td>
                                    </tr>
                                    <tr class="fw-semibold">
                                        <td scope="col" width="61%"></td>
                                        <td class="text-left" scope="col" width="18%"></td>
                                        <td scope="col" width="18%" class="product-subtotal">
                                            <?php
                                            $NewTotBayar = $TotalBayar - ($TotalBayar * ($promo['AMMOUNT'] / 100));
                                            echo "Rp " . number_format($NewTotBayar, 2, ',', '.')
                                            ?>
                                        </td>
                                        <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $NewTotBayar ?>">
                                        <input type="hidden" name="id_promo_code" value="<?= $promo['ID_PROMO'] ?>">
                                    </tr>
                                <?php } else { ?>
                                    <tr class="fw-semibold">
                                        <td scope="col" width="61%"></td>
                                        <td class="text-left product-subtotal" scope="col" width="18%">Total</td>
                                        <td scope="col" width="18%" class="product-subtotal">
                                            <?= "Rp " . number_format($TotalBayar, 2, ',', '.') ?>
                                        </td>
                                        <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $TotalBayar ?>">
                                        <input type="hidden" name="id_promo_code" value="">
                                    </tr>
                                <?php } ?>
                            </thead>
                        </table>
                    </div>
                    <input type="hidden" name="id_trans" value="<?= $id_trans ?>">
                    <input type="hidden" name="id_pay" value="<?= $id_trans ?>">
                    <input type="hidden" name="id_pay_method" value="<?= !empty($checking_trans) ? $checking_trans[0]->ID_PAY_METHOD : '' ?>">
                    <?php foreach ($order[0] as $item) { ?>
                        <input type="hidden" name="id_order_whenPay[]" value="<?= $item->ID_ORDER ?>">
                    <?php } ?>
                </form>
                <div class="d-flex flex-column flex-md-row justify-content-end mt-4">
                    <form action="<?= (!empty($checking_trans)) ? url('delete/pay') : url('checkout') ?>" method="POST" id="form-cancel-trans">
                        @csrf
                        <input type="hidden" name="id_trans" value="<?= (!empty($checking_trans)) ? $id_trans : "" ?>">
                        <?php foreach ($order[0] as $item) { ?>
                            <input type="hidden" name="id_order[]" value="<?= $item->ID_ORDER ?>">
                        <?php } ?>
                    </form>
                    <div class="wc-proceed-to-checkout">
                        <div class="alt btn btn-danger w-100 rounded" style="padding: 0.718047em 1.41575em;" onclick="$('#form-cancel-trans').submit()">
                            Batalkan Transaksi
                        </div>
                    </div>
                    <div>
                        <div id="pay-btn-container"></div>
                    </div>
                    <div class="wc-proceed-to-checkout ms-3">
                        <button type="button" class="checkout-button button alt wc-forward" onclick="CobaPayment()">
                            Ambil Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let timerInterval
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    function CobaPayment() {
        if ($('#total_bayar').val() != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?= Request::segment(0)?>/get_order_id', 
                type: "POST",
                data: {
                    TotPrice: <?= (!empty($promo['AMMOUNT'])) ? ($TotalBayar - ($TotalBayar * ($promo['AMMOUNT'] / 100))) : $TotalBayar ?>,
                    id_order: $('input:hidden[name="id_order[]"]').map(function() {
                        return $(this).val()
                    }).get()
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.token) {
                        Swal.fire({
                            title: 'Open payment gateway ...',
                            html: 'it will be over in a few seconds.',
                            timer: 5000,
                            timerProgressBar: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((resp) => {
                            if (resp.dismiss === Swal.DismissReason.timer) {
                                snap.pay(response.token, {
                                    onSuccess: function(result) {
                                        $('#form-purchase').submit();
                                    },
                                    onPending: function(result) {
                                        $('#form-purchase').submit();
                                    },
                                    onError: function(result) {
                                        $('#form-purchase').submit();
                                    },
                                    onClose: function() {
                                        $('#form-purchase').submit();
                                    }
                                })

                            }
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Payment gateway get some trouble'
                        })
                    }
                }
            });
        } else {
            $('#form-purchase').submit()
        }
    }
</script>