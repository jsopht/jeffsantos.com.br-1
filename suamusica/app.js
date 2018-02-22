let bufferIntervalId
let playing = true
let calcAudioTimeInterval

function calcAudioTime() {
    calcAudioTimeInterval = setInterval(function() {
        console.log('calcAudioTime')

        player = $('#player')[0]

        $('#time-start').text(convertTime(player.currentTime))

        if (! isNaN(player.duration)) {
            $('#time-end').text(convertTime(player.duration - player.currentTime))
        }
    }, 1000)
}

function playerIconByStatus(prop, targetTrue, targetFalse) {
    if ($('#player')[0][prop]) {
        $(targetTrue).parent().show()
        $(targetFalse).parent().hide()
    } else {
        $(targetTrue).parent().hide()
        $(targetFalse).parent().show()
    }
}

function buffer() {
    clearInterval(bufferIntervalId)
    $activeSong = $('.active').next()
    if ($activeSong.length != 0) {

        console.log('Has next music')

        $('#mp3-source-buffer').attr('src', $activeSong.find('.music-url').val())
        bufferIntervalId = setInterval(setBuffer, 2000)
    }
}

function setBuffer() {

    var player = $('#player')[0]
    var pBuffer = $('#player-buffer')[0]

    console.log('setBuffer')

    if (player.readyState == 4 && player.networkState == 1){
        pBuffer.load()
        clearInterval(bufferIntervalId)
    }
}

function convertTime(time) {
    var minutes = parseInt(time / 60, 10)
    var seconds = parseInt(time % 60)

    if (seconds.toString().length < 2)
        seconds = '0' + seconds

    return minutes + ":" + seconds
}

$('form input').bind("paste", function(e) {
    var pastedData = e.originalEvent.clipboardData.getData('text');
    window.location.replace(location.toString().replace(location.search, "") + "?q=" + pastedData);
})

$('.music-box').click(function() {
    $this = $(this)
    player = $('#player')[0]

    clearInterval(calcAudioTimeInterval)

    $('.current-playing').text($this.find('span').text());
    $('.music-box').removeClass('active')
    $this.addClass('active')
    $('#mp3-source').attr('src', $this.find('.music-url').val())

    player.load()

    if ($('.list-group .active').prev().length) {
        $('#btn-previous').removeClass('disabled')
    } else {
        $('#btn-previous').addClass('disabled')
    }

    if ($('.list-group .active').next().length) {
        $('#btn-next').removeClass('disabled')
    } else {
        $('#btn-next').addClass('disabled')
    }

    console.log('play status: ' + playing)

    if (playing) {
        player.play()
    }

    buffer()
    playerIconByStatus('paused', '#btn-play', '#btn-pause')
})

$('#btn-play').click(function() {
    $('#player')[0].play()
    playing = true
    playerIconByStatus('paused', '#btn-play', '#btn-pause')
})

$('#btn-pause').click(function() {
    $('#player')[0].pause()
    playing = false
    playerIconByStatus('paused', '#btn-play', '#btn-pause')
})

$('#btn-next').click(function() {
    $('.list-group .active').next().click();
})

$('#btn-previous').click(function() {
    $('.list-group .active').prev().click();
})

$('#btn-audio-up').click(function() {
    $('#player')[0].muted = true
    playerIconByStatus('muted', '#btn-audio-off', '#btn-audio-up')
})

$('#btn-audio-off').click(function() {
    $('#player')[0].muted = false
    playerIconByStatus('muted', '#btn-audio-off', '#btn-audio-up')
})

$('#options').click(function() {
    $('#player').toggleClass('show-native-controls')
})

player.onplay = function() {
    calcAudioTime()
    console.log('playing ' + playing)
}

player.onpause = function() {
    clearInterval(calcAudioTimeInterval)
    console.log('paused' + playing)
}

player.onended = function() {
    $('.list-group .active').next().click();
};

$('.list-group .active').click();

playerIconByStatus('muted', '#btn-audio-off', '#btn-audio-up')
