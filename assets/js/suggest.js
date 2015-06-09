$(document).ready(function () {
    $('div#output').hide();
    $('#send-message').click(sendMessage);
    $('div#output button').live('click', function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        $('div#output').hide();
        return false;
    });
});

/* Regular Check*/
function checkEmail(email) {
    var check = /^[\w\.\+-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]{2,6}$/;
    if (!check.test(email))
        return false;
    return true;
}


var submit_message() = function (
        function sendMessage() {
            // receive the provided data
            var fname = $("input#fname").val();
            var email = $("input#email").val();
            var message = $("textarea#message").val();
    
            if (fname == '') {
                $("input#fname").addClass('has-error')
            }

            if (fname == '' || email == '' || message == '') {
                $("div#output").removeClass('alert-success').addClass('alert-error').show().html('<div class="alert-content"><button type="button" class="close" data-dismiss="alert-content">x</button>要把每个格子都填写好哦</div>');
                return false;
            }

            // verify the email address
            if (!checkEmail(email)) {
                $("div#output").removeClass('alert-success').addClass('alert-error').show().html('<div class="alert-content"><button type="button" class="close" data-dismiss="alert-content">x</button>邮箱是不是写错了呢？再检查检查</div>');
                return false;
            }

            // make the AJAX request
            var dataString = $('#cform').serialize();
            $.ajax({
                type: "POST",
                url: 'contact.php',
                data: dataString,
                dataType: 'json',
                success: function (data) {
                    if (data.success == 0) {
                        var errors = '<ul><li>';
                        if (data.name_msg != '')
                            errors += data.name_msg + '</li>';
                        if (data.email_msg != '')
                            errors += '<li>' + data.email_msg + '</li>';
                        if (data.message_msg != '')
                            errors += '<li>' + data.message_msg + '</li>';

                        $("div#output").removeClass('alert-success').addClass('alert-error').show().html('<div class="alert-content"><button type="button" class="close" data-dismiss="alert-content">x</button>哎呀，出错了！</div>' + errors);
                    } else if (data.success == 1) {

                        $("div#output").removeClass('alert-error').addClass('alert-success').show().html('<div class="alert-content"><button type="button" class="close" data-dismiss="alert-content">x</button>You message has been sent successfully!</div>');
                    }

                },
                error: function (error) {
                    $("div#output").removeClass('alert-success').addClass('alert-error').show().html('<div class="alert-content"><button type="button" class="close" data-dismiss="alert-content">x</button>哎呀，出错了！</div>' + error);
                }
            });

            return false;
        }