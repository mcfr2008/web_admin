
<script type="text/javascript">
    $(document).ready(function (e) {

        // $('.row_validate').hide();
        // $('.row_validate').removeClass('hidden');

        $('.row_validate').addClass('hidden');

        $('select[name=database] option:eq(1)').attr('selected', 'selected');

        $('#loginForm').submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var data = $(this).serializeArray();

            if ($(this).find('#username').val() === '') {
                $('#username').focus();
            } else if ($(this).find('#password').val() === '') {
                $('#password').focus();
            } else {
                
                $.ajax({
                    url: url,
                    type: method,
                    dataType: "JSON",
                    data: data
                }).done(function (data) {

					console.log(data)

                    if (data.people_login === 1) {
                        location.reload();
                    } else {
                        $('.row_validate').removeClass('hidden');
                        $('#validate').html('รหัสผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
                        $('#username').focus();
                        $('#username').val('');
                        $('#password').val('');
                    }
                }).fail(function () {
					console.log(data)
                    $('.row_validate').removeClass('hidden');
                    $('#validate').html('เกิดข้อผิดพลาด');
                });
            }
        });
        // $('#username,#password').change(function (e) {
        //     $('#validate').html('');
        // });
        // $('#LoginModal').on('shown.bs.modal', function (e) {
        //     $('#username').focus();
        // });

    });
</script>
