$(document).ready(function () {
  var links = [
    {
      name: 'Discord',
      link: 'https://discord.com/users/1019337321532903434',
    },

    {
      name: 'Steam',
      link: 'https://steamcommunity.com/id/efial',
    },

    {
      name: 'GitHub',
      link: 'https://github.com/Efial',
    },
  ];

  for (var i in links) {
    var link = links[i];

    $('#marquee').append('<a href="' + link.link + '" target="_BLANK">' + link.name + '</a>');

    link = $('#marquee').children('a').last();

    if (i != links.length - 1) $('#marquee').append(' | ');
  }
});

$(function () {
  var $diaplay = $('#display');
  $('.marquee')
    .bind('beforeStarting', function () {
      $diaplay.show().html('started').delay(2000).fadeOut('fast');
    })
    .marquee({
      duration: 4000,
    });
});
