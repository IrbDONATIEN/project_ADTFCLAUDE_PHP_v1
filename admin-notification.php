<?php
    require_once 'php/admin-header.php';
?>

         <!--Début de la ligne 1-->
         <div class="row justify-content-center my-5">
            <div class="col-lg-6 mt-4" id="showNotification">
            </div>
        </div>
        <!--Fin de la ligne 1-->

        <!--Footer Area-->
            </div>
        </div>
     </div>
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
     <script type="text/javascript">
        $(document).ready(function(){
            //Fetch Notification Ajax Request
            fetchNotification();

            function fetchNotification(){
                $.ajax({
                    url: 'php/admin-action.php',
                    method:'post',
                    data:{action: 'fetchNotification'},
                    success:function(response){
                        $("#showNotification").html(response);
                    }
                });

            }

            //Check Notification
            checkNotification();

            function checkNotification(){
                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{action:'checkNotification'},
                    success:function(response){
                        $("#checkNotification").html(response);
                    }
                });
            }

            //Remove notification
            $("body").on("click", ".close", function(e){
                e.preventDefault();

                notification_id=$(this).attr('id');

                $.ajax({
                    url:'php/admin-action.php',
                    method:'post',
                    data:{notification_id:notification_id},
                    success:function(response){
                        fetchNotification();
                        checkNotification();
                    }
                });

            });

        });
    </script>
</body>
</html>