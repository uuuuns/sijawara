<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
</head>

<style>
    @page {
            margin: 0;
            size: 1280px 720px;
        }
    
</style>

<body style="font-family: Poppins, sans-serif; font-size: 14px; margin: 0;">
    <div class="wrapper-page" style="position: relative;">
        <div class="box" style="position: absolute;">
            <div class="image">
                <img src="<?= $IMAGE ?>" style="width: 1280px; height: 720px;">
            </div>
        </div>

        <div class="box" style="position: absolute;">
            <div class="table-responsive">
                <table class="valign-middle" style="width: 100%; vertical-align: middle; border: none; border-collapse: collapse; color: black; padding: 48% 56%;">
                    <tr>
                        <th class="text-align-center" style="text-align: center; border: none;">
                            <div class="text name" style="width: 580px; font-size: 29px; font-weight: bold; color: black; line-height: 121%; padding: 1% 0px;">
                                <?= $NAME ?>
                            </div>
                        </th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="box" style=" font-family: Poppins, sans-serif; position: absolute; margin-left: 140px;">
            <div style="text-align: left; font-size: 15px; margin-top: 370px; max-width: 650px;">
                <div style="font-size: 25px; font-weight: bold;">
                    <?= $ROLES?>
                </div>
                dalam kegiatan <span style="font-weight: bold"><?= $JUDUL?></span> yang diselenggarakan oleh
                <br>
                UPT Pelatihan Koperasi dan UKM Provinsi Jawa Timur, 
                <br>
                pada tanggal <?= $TGL_ACARA?>
            </div>
        </div>

        <div class="box" style="position: absolute; margin-left: 875px; font-size: 13px; font-weight: bold; margin-top: 375;">
            MALANG, <?= $TGL_TTD?>
        </div>

        <div class="box" style="position: absolute; margin-left: 150px; font-size: 13px; font-weight: bold; margin-top: 405;">
            <img src="data:image/svg+xml;base64,<?= $QR?>" alt="" style="max-width: 100px;">
        </div>
    </div>
</body>

</html>
