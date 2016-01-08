(function($,W,D)
{
    var ML2 = {};

    ML2.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#mailing-list").validate({
                rules: {
                	ml2_name: "required",
                	ml2_email: {
                		required: true,
                		email: true
                	},
                	ml2_phone: "required"
                    /*firstname: "required",
                    lastname: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    agree: "required"*/
                },
                messages: {
                	ml2_name: "Please enter your full name!",
                	ml2_email: "Please enter a valid email!",
                	ml2_phone: "Please enter your phone number!"
                    /*firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    email: "Please enter a valid email address",
                    agree: "Please accept our policy"*/
                },
                errorLabelContainer: "#ml2-errors",
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        ML2.UTIL.setupFormValidation();
    });

})(jQuery, window, document);