jQuery(document).ready(function($) {
  $('.wp-g2-reviews').each(function () {

    var current = $(this);
    
    // get question
    var question1 = $(this).find('div[data-qus="1"]').html();
    var question2 = $(this).find('div[data-qus="2"]').html();
    var question3 = $(this).find('div[data-qus="3"]').html();

    // create reviews boxes
    $(this).children('.wp-g2-rev-data').children('.wp-g2-answer').each(function () { 
      var revnumb = $(this).attr('data-num');
      var answer1 = $(this).find('div[data-ans="1"]').html();
      var answer2 = $(this).find('div[data-ans="2"]').html();
      var answer3 = $(this).find('div[data-ans="3"]').html();
      $(current).children('.wp-g2-rev-front').append('<div data-rev="'+ revnumb +'"><div class="rev-q">'+question1+'</div><div class="rev-a">'+answer1+'</div><div class="rev-q">'+question2+'</div><div class="rev-a">'+answer2+'</div><div class="rev-q">'+question3+'</div><div class="rev-a">'+answer3+'</div></div>');
    });

  });

});