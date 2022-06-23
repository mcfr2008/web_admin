$('.pagination').empty();

if(parseInt(pageNumber) > 5){
	$('.pagination').append('<li><button class="pageNumber">1</button></li>');
	$('.pagination').append('<li><button class="pageNumber" disabled>...</button></li>');
}

for (var i = 1; i <= total; i++) {
	if(parseInt(pageNumber)-5 < i && parseInt(pageNumber)+7 > i){
		if(parseInt(pageNumber)+1 == i){
			$('.pagination').append('<li><button class="pageNumber active">'+i+'</button></li>');
		}else{
			$('.pagination').append('<li><button class="pageNumber">'+i+'</button></li>');
		}
	}
}

if(parseInt(pageNumber) < total-6){
	$('.pagination').append('<li><button class="pageNumber" disabled>...</button></li>');
	$('.pagination').append('<li><button class="pageNumber">'+total+'</button></li>');
}
