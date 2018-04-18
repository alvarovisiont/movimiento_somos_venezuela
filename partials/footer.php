    </div>
  </div>
  </section>

<!-- Vendor -->
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/jquery/jquery.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/bootstrap/js/bootstrap.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/nanoscroller/nanoscroller.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/magnific-popup/magnific-popup.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/jquery-placeholder/jquery.placeholder.js' ?>"></script>
        
        <!-- Specific Page Vendor -->
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/select2/select2.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/jquery-datatables/media/js/jquery.dataTables.js' ?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/vendor/jquery-datatables-bs3/assets/js/datatables.js' ?>"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="<?= $_SESSION['base_url1'].'assets/javascripts/theme.js'?>"></script>
        
        <!-- Theme Custom -->
        <script src="<?= $_SESSION['base_url1'].'assets/javascripts/theme.custom.js'?>"></script>
        
        <!-- Theme Initialization Files -->
        <script src="<?= $_SESSION['base_url1'].'assets/javascripts/theme.init.js'?>"></script>

        <!-- Examples -->
        <script src="<?= $_SESSION['base_url1'].'assets/javascripts/tables/examples.datatables.default.js' ?>"></script>

        <script src="<?= $_SESSION['base_url1'].'assets/javascripts/tables/examples.datatables.editable.js'?>"></script>
        <script src="<?= $_SESSION['base_url1'].'assets/js/toastr.js'?>"></script>
  </body>
</html>

<script>
    $(function(){
        $('[data-tool="tooltip"]').tooltip()

        let type = "<?= isset($_SESSION['flash']) ? $_SESSION['flash'] : null ?>";

        if(type)
        {
            switch(type)
            {
                case '1':
                    toastr.success('Operación realizada con éxito','Éxito!')
                break;

                case '2':
                    toastr.error('Ha ocurrido un error al ejecutar la operación','Error!')
                break;
            }

            <? unset($_SESSION['flash']); ?>
        }

        $('.remover_helper').click(function(){
            let agree = confirm('Esta seguro de querer eliminar este registro?')

            if(!agree)
            {
                return false
            }
        })
    })
</script>