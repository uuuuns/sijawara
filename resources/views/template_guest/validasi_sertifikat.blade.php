<div class="container">
    <h1 class="text-center my-4">Detail Sertifikat</h1>
    
    <div class="certificate mb-3">
        <h2 class="text-center">Nama Pemilik Sertifikat</h2>
        <h4 class="text-center">{{$sertifikat->NAME}}</h4>
        
        <h3 class="text-center my-3">Kegiatan yang Diikuti</h3>
        <p class="text-center">{{$sertifikat->TITLE_ACTIVITY}}</p>
        
        <h3 class="text-center my-3">Sertifikat</h3>
        <iframe src="{{$sertifikat->FILE_SERTIFIKAT}}#toolbar=0&navpanes=0" style="width:600px; height:420px;" class="img-fluid mx-auto d-block" frameborder="0"></iframe>
    </div>
</div>

