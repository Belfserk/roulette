initializeRoulette();

$(document).on('click', '#roll', function () {
    roll();
});

function getStats()
{
    $.ajax({
        url: Routing.generate('api_number_of_players'),
        method: 'GET'
    }).done(function (result) {
        console.log(result);
    });

    $.ajax({
        url: Routing.generate('api_active_players'),
        method: 'GET'
    }).done(function (result) {
        console.log(result);
    });
}

function roll()
{
    let playerId = $.cookie('playerId');
    $.ajax({
        url: Routing.generate('api_roll'),
        method: 'POST',
        data: {
            playerId: playerId
        }
    }).done(function (result) {
        $('#round-number span').html(result.round);
        $('#current-number span').html(result.rolledNumber);
    });
}

function initializeRoulette()
{
    let playerId = $.cookie('playerId');
    $.ajax({
        url: Routing.generate('api_init'),
        method: 'POST',
        data: {
            playerId: playerId
        }
    }).done(function (result) {
        $.cookie('playerId', result.playerId);
        $('#round-number span').html(result.round);
    });
}