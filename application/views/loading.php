<?php
include_once('includes/head.php');
?>
<style>
    .card-body p{
        font-weight: bold;
        font-size: 1.50rem;
        max-width: 100%;
    }
    .cartitle{
        width: 100%;
        border-bottom: 1px solid #000;
    }
    .content-actividades{
        margin-top: 20px;
    }
    .actividades{
        margin-top: 5px;
        text-align: center;
    }
    .actividades span{
        font-size: 1.10rem;
        margin-left: 5px;
    }
    .cargar-mas{
        margin-top: 10px;
    }
    .logo_utp{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .chart {
    background: rgba(255, 255, 255, 0.1);
    justify-content: flex-start;
    border-radius: 100px;
    align-items: center;
    position: relative;
    padding: 0 5px;
    display: flex;
    height: 40px;
    width: 500px;
}
    .chart span {
        /* You can modify the value below to change the distance between the percentage number and the bar */
        margin-left: 5px;
        color: #fff;
        font-weight: bolder;
    }

.bar {
    /* You can modify the total time used for the animation here */
    animation: load 3s normal forwards;
    /* 
    Add a little spice by having a shadow below the bar.
    Feel free to comment out this line below to have an even LITE version :D 
    */
    box-shadow: 0 10px 40px -10px #fff;

    border-radius: 100px;
    background: #fff;
    height: 30px;
    width: 0;
} 

@keyframes load {
    0% {
        width: 0;
    }
    100% {
        /* You need to change the percentage below to match the value in the corresponding <span> */
        width: 68%;
    }
}
</style>

            <div class="container-fluid" style="margin-top: 15%; width: 700px;">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="cartitle">
                                    <p>Nos enfocamos en brindarte el mejor servicio</p>
                                </div>
                                <div class="content-actividades">
                                    <div class="actividades">
                                        <span>Nos encontramos cargando la información al sistema...</span><br>
                                        <span>Te notificaremos cuando acabe el proceso, tomate un descanso.</span>
                                    </div>
                            </div>
                            <div class="progress" style="height: 30px">
                                    <div class="progress-bar bg-success" style="width: 75%;" role="progressbar">75%</div>
                                </div>
                                    <div class="logo_utp">
                                <img src="../public/images/logo_utp.png" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<script>
    // Github verson (1 file .html): https://github.com/Soooda/progress_bar_lite/blob/master/index.html


</script>
<?php
include_once('includes/js.php');
?>