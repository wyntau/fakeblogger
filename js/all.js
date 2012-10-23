$(function() {
	$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
	$('#up').mouseover(function() {
		up()
	}).mouseout(function() {
		clearTimeout(fq)
	}).click(function() {
		$body.animate({
			scrollTop: $('#header').offset().top
		},
		500)
	});
	$('#down').mouseover(function() {
		dn()
	}).mouseout(function() {
		clearTimeout(fq)
	}).click(function() {
		$body.animate({
			scrollTop: $('#footer').offset().top
		},
		500)
	});
	$('#comt').click(function() {
		$body.animate({
			scrollTop: $('#comments').offset().top
		},
		500)
	})
});
function up() {
	$wd = $(window);
	$wd.scrollTop($wd.scrollTop() - 1);
	fq = setTimeout("up()", 40)
}
function dn() {
	$wd = $(window);
	$wd.scrollTop($wd.scrollTop() + 1);
	fq = setTimeout("dn()", 40)
}
$(function() {
Function.prototype.method = function(v, w) {
		if (!this.prototype[v]) {
			this.prototype[v] = w
		}
		return this
	};
function m(v) {
		return document.getElementById(v)
	}
function h(y) {
		var x = m("comment");
		if (y) {
			if (document.selection) {
				sel = document.selection.createRange();
				sel.text = y
			} else {
				if (x.selectionStart || x.selectionStart == "0") {
					var w = x.selectionStart;
					var v = x.selectionEnd;
					var z = w;
					x.value = x.value.substring(0, w) + y + x.value.substring(v, x.value.length);
					z += y.length;
					x.selectionStart = z;
					x.selectionEnd = z
				} else {
					x.value += y
				}
			}
		}
	}
function e() {
		var x = $(".replyto");
		var w = $(".quote");
		var v = function(B) {
			var C = $(B).attr("href").replace(/.*#comment-/, "");
			//alert(C);
			var z = $("#comment-" + C + " .fn").text();
			//alert(z);
			var A = $("#comment-" + C + " .comment-content").html();
			//alert(A);
			return {
				id: C,
				name: z,
				content: A
			}
		};
		var y = function(z) {
			var B = $("#comment");
			var A = B.val();
			if (A.indexOf(z) > -1) {
				alert("You've already appended this!");
				return false
			}
			
			$.scrollTo(B, 600, {
				easing: "easeOutBounce",
				onAfter: function() {
					B.focus();
					if (A.replace(/\s|\t|\n/g, "") == "") {
						h(z)
					} else {
						h("\n\n" + z)
					}
				}
			})
			
		};
		x.click(function() {
			var A = v(this);
			var z = '<a href="#comment-' + A.id + '">@' + A.name + " </a>\n";
			y(z);
			return false
		});
		w.click(function() {
			var A = v(this);
			var z = '<blockquote cite="#commentbody-' + A.id + '">';
			z += '\n<strong><a href="#comment-' + A.id + '">' + A.name + "</a> :</strong>";
			z += A.content;
			z += "</blockquote>\n";
			z = z.replace(/\t/g, "");
			y(z);
			return false
		})
	}
	e();
function s() {
		var commentform=$("#commentform");
		var calldata=commentform.serialize();
		var ajaxbox=$("#ajaxbox");
		var submit=$("#submit");
		var callurl=themeurl+"/comment-ajax.php";
		var beforesend=function(){
			ajaxbox.slideDown(300);
			submit.attr("disabled",true);
		};
		var errorlog=function(G) {
			if (G.responseText) {
				alert(G.responseText)
			} else {
				alert("评论错误!")
			}
			ajaxbox.slideUp(200);
			submit.attr("disabled",false);
		};
		var succ=function(G){
				$("#comment").val("");
				$("#comments").append(G);
				ajaxbox.slideUp(600);
				var H = $("#comments li:last").hide();
				H.slideDown(600);
				submit.attr("disabled",false);
		};
		$.ajax({
			url:callurl,
			data:calldata,
			type:"POST",
			dataType:"html",
			beforeSend:beforesend,
			error:errorlog,
			success:succ
		})
		
	}
	function q() {
		$("#commentform").submit(function() {
			s();
			return false
		});
		$("#commentform #comment").keydown(function(v) {
			if ((v.ctrlKey || v.altKey) && (v.keyCode == 13 || v.keyCode == 83)) {
				s();
				return false
			}
		})
	}
	q();
});
