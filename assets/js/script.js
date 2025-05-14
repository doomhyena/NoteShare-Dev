document.addEventListener('DOMContentLoaded', function () {
    const searchBox = document.getElementById("search-box");
    if (searchBox) {
        searchBox.addEventListener('keyup', (e) => {
            var ertek = e.target.value;
            $("#search").html("Keresés folyamatban...");
            $("#search").load("assets/php/findanything.php?keresett=" + encodeURIComponent(ertek));
        });
    }

    const friendId = new URLSearchParams(window.location.search).get('friendid');
    let lastMessageCount = 0;

    function checkNewMessages() {
        if (!friendId) return;
        $.get("assets/php/loadmessages.php?friendid=" + encodeURIComponent(friendId) + "&countonly=1", function (newCount) {
            if (parseInt(newCount) > lastMessageCount) {
                $(".messages").load("assets/php/loadmessages.php?friendid=" + encodeURIComponent(friendId));
                lastMessageCount = parseInt(newCount);
            }
        });
    }

    if (friendId) {
        $(".messages").load("assets/php/loadmessages.php?friendid=" + encodeURIComponent(friendId), function () {
            $.get("assets/php/loadmessages.php?friendid=" + encodeURIComponent(friendId) + "&countonly=1", function (newCount) {
                lastMessageCount = parseInt(newCount);
            });
        });
    }

    setInterval(checkNewMessages, 1000);

    $('form').submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const messageInput = form.find('input[name="message"]');
        const toid = form.find('input[name="toid"]').val();
        const message = messageInput.val().trim();

        if ($('#message-status').length === 0) {
            form.after('<div id="message-status" style="margin-top: 10px;"></div>');
        }

        const statusDiv = $('#message-status');

        if (message.length === 0) {
            statusDiv.text('❌ Nem küldhetsz üres üzenetet.').css('color', 'red');
            return;
        }

        $.post('messages.php', {
            toid: toid,
            message: message
        })
        .done(function () {
            $(".messages").load("assets/php/loadmessages.php?friendid=" + encodeURIComponent(toid));
            messageInput.val('');
            statusDiv.text('✅ Üzenet elküldve.').css('color', 'green');
            $.get("assets/php/loadmessages.php?friendid=" + encodeURIComponent(toid) + "&countonly=1", function (newCount) {
                lastMessageCount = parseInt(newCount);
            });
        })
        .fail(function () {
            statusDiv.text('❌ Hiba történt az üzenet küldése közben.').css('color', 'red');
        })
        .always(function () {
            setTimeout(() => {
                statusDiv.fadeOut(400, function () {
                    $(this).text('').css('display', 'block');
                });
            }, 3000);
        });
    });
});

function showForm(form){
		
    if(form == "reg"){
        document.getElementById("reg").style.display = "block";
        document.getElementById("login").style.display = "none";
    } else {
        document.getElementById("login").style.display = "block";
        document.getElementById("reg").style.display = "none";    
    }
}