document.addEventListener("DOMContentLoaded", function() {
    document.body.scrollTop; //force css repaint to ensure cssom is ready

    var timeout; //global timout variable that holds reference to timer
console.log('loaded');
    var captcha = new $.Captcha({
        onFailure: function() {

            $(".captcha-chat .wrong").show({
                duration: 30,
                done: function() {
                    var that = this;
                    clearTimeout(timeout);
                    $(this).removeClass("shake");
                    $(this).css("animation");
                    //Browser Reflow(repaint?): hacky way to ensure removal of css properties after removeclass
                    $(this).addClass("shake");
                    var time = parseFloat($(this).css("animation-duration")) * 1000;
                    timeout = setTimeout(function() {
                        $(that).removeClass("shake");
                    }, time);
                }
            });

        },

        onSuccess: function() {
            alert("CORRECT!!!");
            console.log('test');
            event.preventDefault();
           $('.submit').prop('disabled',false);
           // $('.submit').removeAttr('disabled');
        }
    });

    captcha.generate();
});
