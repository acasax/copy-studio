
$(function () {


    $(document).on('click', '#logout', function () {
        localStorage.removeItem('token');
    })

    const checkJWT = () => {
        let jwt = localStorage.getItem('token')
        if (jwt) {
            $.ajax({
                url: "ajax/global/checkJWT.php",
                type: "POST",
                data: {
                    jwt: jwt,
                },
                dataType: "JSON",
                success: function success(data) {
                    if (data) {
                        if (data.type && data.type === "LOGOUT") {
                            window.location.replace('../prijava')
                            return;
                        }
                    }
                },
                error: function error() {

                }
            })
        } else {
            logout()
            window.location.replace('./prijava');
        }
    }

    checkJWT();

})