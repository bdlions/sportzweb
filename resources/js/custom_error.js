$(function() {
    $(document).tooltip();
    $.validator.setDefaults({
        success: function(label, element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            return false;
        },
        showErrors: function(errorMap, errorList) {
            this.defaultShowErrors();
            $("#message").html("").removeAttr("class");

            this.has_required_error = false;
            var self = this;

            $.each(errorMap, function(key, value) {
                if (value === "required") {
                    self.has_required_error = true;
                    return;
                }
            });

            if (this.has_required_error) {
                $("#message").html("You must complete all of the fields").attr("class", "error-message");
            }
            else {
                $.each(errorMap, function(key, value) {
                    if (value !== "required") {
                        $("#message").html(value).attr("class", "error-message");
                    }
                });

            }

        }
    });
});