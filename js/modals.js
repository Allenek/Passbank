
$(document).ready(function() {

  if(typeof jQuery().deleteConfirm !== "undefined")
      $(".delete-button").deleteConfirm();

  if(typeof jQuery().loadModal !== "undefined")
    $('.add-button').loadModal({
      additionalFunctions: [
        function() {
          $(document).ready(function() {
            $('.validate-form').submit(function(e){
              var pass = $('input[name=password]');
              var passRepeat =  $('input[name=confirm-password]');
              var mainPass =  $('input[name=main-password]');
              if (pass.val() === passRepeat.val()) {
                var encrypted = CryptoJS.AES.encrypt(pass.val(), mainPass.val());
                pass.val(encrypted);
                passRepeat.val(encrypted);
              }
            });
          });
        },
      ]
    });

  if(typeof jQuery().loadModal !== "undefined")
      $('#NavBarRegister').loadModal();

  if(typeof jQuery().loadModal !== "undefined")
      $('.password-decrypt').loadModal({
        additionalFunctions: [
          decryptPwd,
        ],
        selectorModal : '#modal-password',       //selektor okna modalnego z formularzem
        selectorContent : '.modal-content-password', //miejsce załadowania wczytanego widoku formularza
      });
});
