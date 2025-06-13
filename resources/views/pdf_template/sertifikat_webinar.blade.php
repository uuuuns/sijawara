<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1280px, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        @page {
            margin: 0;
            size: 1280px 720px;
        }

        body {
            font-family: Poppins, sans-serif;
            font-size: 14px;
            margin: 0;
        }

        .wrapper-page {
            position: relative;
        }

        .image img {
            width: 1280px;
            height: 720px;
        }

        .table-container {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translateX(-50%);
            width: 800px; /* atau 700px jika ingin lebih kecil */
        }


        table {
            width: 100%;
            border-collapse: collapse;
            color: black;
            font-size: 14px;
            font-weight: bold;
        }

        th, td {
            border: 2px solid black;
            padding: 8px;
            text-align: center;
        }

        .total-row td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="wrapper-page">
        <div class="box image">
            <img src="<?= $IMAGE_HAL_2 ?>">
        </div>

        <div class="box table-container">
            <table>
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>TEMA</th>
                        <th>JAM PELAJARAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($LIST_TEMA as $key => $item)
                    <tr>
                        @if ($key == 0)
                            <td><?= $TGL_ACARA ?></td>
                        @else
                            <td></td>
                        @endif
                        <td><?= $item['TEMA'] ?></td>
                        <td><?= $item['JP'] ?></td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>TOTAL</td>
                        <td></td>
                        <td><?= $TOTAL_JP ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
