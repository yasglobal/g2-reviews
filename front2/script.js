jQuery(document).ready(function ($) {
	$(".wp-g2-reviews").each(function () {
		var current = $(this);

		// get question
		var question1 = current.find('div[data-qus="1"]').html();
		var question2 = current.find('div[data-qus="2"]').html();
		var question3 = current.find('div[data-qus="3"]').html();

		// create reviews box
		var firstBox = current.find('.wp-g2-answer[data-num="1"]');
		var revnumb = $(firstBox).attr("data-num");
		var revtopic = $(firstBox).attr("data-topic");
		var revname = $(firstBox).attr("data-reviewer");
		if ($(firstBox).attr("data-iconurl")) {
			var revicon = $(firstBox).attr("data-iconurl");
			var revicon = '<img src="' + revicon + '">';
		} else {
			var revicon = revname.substring(0, 1);
		}

		var answer1 = $(firstBox).find('div[data-ans="1"]').html();
		var answer2 = $(firstBox).find('div[data-ans="2"]').html();
		var answer3 = $(firstBox).find('div[data-ans="3"]').html();
		$(current)
			.children(".wp-g2-rev-front")
			.append(
				'<div data-rev="' +
					revnumb +
					'"><div class="rev-user-icon"><span>' +
					revicon +
					"</span><span>" +
					revname +
					'</span></div><div class="rev-topic">' +
					revtopic +
					'</div><div class="rev-q">' +
					question1 +
					'</div><div class="rev-a">' +
					answer1 +
					'</div><div class="rev-q">' +
					question2 +
					'</div><div class="rev-a">' +
					answer2 +
					'</div><div class="rev-q">' +
					question3 +
					'</div><div class="rev-a">' +
					answer3 +
					"</div></div>"
			);

		//create thumb and arrows
		current
			.children(".wp-g2-rev-front")
			.prepend(
				'<div class="rev-arrows"><span calss="rev-arrow-left">🠜</span><span calss="rev-arrow-right">🠞</span></div>'
			);
		current
			.children(".wp-g2-rev-front")
			.append('<div class="rev-thumb" />');
		current.find(".wp-g2-answer").each(function () {
			$(this)
				.parents(".wp-g2-rev-data")
				.prev(".wp-g2-rev-front")
				.children(".rev-thumb")
				.append("<i/>");
		});
		current.find(".rev-thumb i:first-child").addClass("active");

		//click actions
		current.find(".rev-thumb i").on("click", function () {
      if (!$(this).hasClass("active")) {
        var currentThumb = $(this).index()+1;
        console.log(currentThumb);
				$(this).siblings("i.active").removeClass("active");
        $(this).addClass("active");
        
        //slide change
        

			}
		});

		//Arrow Click
		current.find(".rev-arrows span").on("click", function () {
			var currentThumb = current.find(".rev-thumb i.active");
			if ($(this).is(":last-child")) {
				if (currentThumb.is(":last-child")) {
					current.find(".rev-thumb i:first-child").trigger("click");
        } else {
          currentThumb.next("i").trigger("click");
				}
			} else {
				if (currentThumb.is(":first-child")) {
					current.find(".rev-thumb i:last-child").trigger("click");
				} else {
					currentThumb.prev("i").trigger("click");
				}
			}
		});

		// loop boxes

		// div[data-rev]
	});
});
