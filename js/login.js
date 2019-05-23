$('.toggle').on('click', function() {
  $('.container').stop().addClass('active');
  $('.card.alt form').addClass('show');
});

$('.close').on('click', function() {
  $('.container').stop().removeClass('active');
  $('.card.alt form').removeClass('show');
});