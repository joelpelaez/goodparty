/**
 * Capture the current order and initialize the process
 * 
 * @param id Model identifier.
 */
var client;

function order() {
	$.get(base_url + '/client', function(data) {
		var clients = data;
		var list = $("#client-list");
		for (i in clients) {
			var element = $("<option/>");
			element.val(clients[i].id);
			element.text(clients[i].firstname + " " + clients[i].lastname);
			list.append(element);
		}
	});
	$(".modal").modal({
		backdrop:'static',keyboard:'false',
	});
}