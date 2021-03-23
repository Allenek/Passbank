$(document).ready(function() {
  $('#dcpt').click(function() {
    console.log('test');
  });
  $('#datatables').DataTable({
    dom: "frtipl"
  });
  $('validate-form').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize()
                }).done(function (data) {
                    $('.message').html(data);
                }).fail(function (data) {
                    console.log('Error: Failed to submit form.')
                });
  });
  $('.captcha-holder').iconCaptcha({
                    theme: ['light', 'dark'], // Select the theme(s) of the Captcha(s). Available: light, dark
                    fontFamily: '', // Change the font family of the captcha. Leaving it blank will add the default font to the end of the <body> tag.
                    clickDelay: 500, // The delay during which the user can't select an image.
                    invalidResetDelay: 3000, // After how many milliseconds the captcha should reset after a wrong icon selection.
                    requestIconsDelay: 1500, // How long should the script wait before requesting the hashes and icons? (to prevent a high(er) CPU usage during a DDoS attack)
                    loadingAnimationDelay: 1500, // How long the fake loading animation should play.
                    hoverDetection: true, // Enable or disable the cursor hover detection.
                    showCredits: 'show', // Show, hide or disable the credits element. Valid values: 'show', 'hide', 'disabled' (please leave it enabled).
                    enableLoadingAnimation: true, // Enable of disable the fake loading animation. Doesn't actually do anything other than look nice.
                    validationPath: '../class/Tools/Captcha/captcha-request.php', // The path to the Captcha validation file.
                    messages: { // You can put whatever message you want in the captcha.
                        header: "Select the image that does not belong in the row",
                        correct: {
                            top: "Great!",
                            bottom: "You do not appear to be a robot."
                        },
                        incorrect: {
                            top: "Oops!",
                            bottom: "You've selected the wrong image."
                        }
                    }
                })
                    .bind('init.iconCaptcha', function(e, id) { // You can bind to custom events, in case you want to execute some custom code.
                        console.log('Event: Captcha initialized', id);
                    }).bind('selected.iconCaptcha', function(e, id) {
                    console.log('Event: Icon selected', id);
                }).bind('refreshed.iconCaptcha', function(e, id) {
                    console.log('Event: Captcha refreshed', id);
                }).bind('success.iconCaptcha', function(e, id) {
                    console.log('Event: Correct input', id);
                }).bind('error.iconCaptcha', function(e, id) {
                    console.log('Event: Wrong input', id);
                });


});
