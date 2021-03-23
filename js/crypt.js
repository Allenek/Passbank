function decryptPwd() {
  var key = undefined;
  var beforeBlock = $('#before');
  var afterBlock = $('#after');
  var mainPassInput = $('#main-pass');
  var mainPassBtn = $('#main-pass-btn');

  afterBlock.hide();

  mainPassBtn.click(function() {
    key = mainPassInput.val();

    console.log('key');
    if (key != undefined && key.length > 0) {
      var pass = $('#passwd').text();
      var decrypted = CryptoJS.AES.decrypt(pass, key).toString(CryptoJS.enc.Utf8);

      if (decrypted.length > 0 ) {
        $('#passwd').html(decrypted);
        beforeBlock.hide();
        afterBlock.show();
      }
    }
  });
}
