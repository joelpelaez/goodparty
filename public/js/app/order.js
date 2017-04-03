/**
 * Capture the current order and initialize the process
 * 
 * @param id
 *                Model identifier.
 */
var order_url;

function setOrderUrl(url) {
    order_url = url;
    setOrderUrl = undefined;
}

var client;
var first_load = true;

function formatDate() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function show_add_client() {
    $("#add-client-form").show();
}

function add_client(e) {
    e.preventDefault();
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var email = $("#email").val();
    var phone = $("#phone").val();

    if (firstname === '' || lastname === '') {
	return false;
    }

    var client = {
	firstname : firstname,
	lastname : lastname,
	email : email,
	phone : phone
    };

    $.ajax({
	method : 'POST',
	url : base_url + '/client',
	data : client,
	success : function(data) {
	    console.log(data);
	    $("#add-client-form").hide();
	    get_client_list(data.transaction_id);
	}
    });

    return false;
}

function get_client_list(id) {
    $.get(base_url + '/client', function(data) {
	var clients = data;
	var list = $("#client-list");
	list.empty();
	for (i in clients) {
	    var element = $("<option/>");
	    element.val(clients[i].id);
	    element.text(clients[i].firstname + " " + clients[i].lastname);
	    list.append(element);
	    if (typeof (id) === 'number')
		list.val(id);
	}
    });
}

function order() {
    if (first_load) {
	get_client_list();
	first_load = false;
    }
    $(".temporal").remove();
    var table = $("#change-table");
    for (i in changes) {
	var row = $('<tr class="temporal">');
	row.append($("<td>" + i + "</td>"));
	row.append($("<td>" + changes[i].type + "</td>"))
	row.append($("<td>" + changes[i].value + "</td>"));
	table.append(row);
    }
    $(".modal").modal({
	backdrop : 'static',
	keyboard : 'false',
    });
    $("#add-client-form").submit(add_client);
}

function add_order() {
    var client_id = $("#client-list").val();
    var model_id = $("#model-id").val();
    var pchanges = [];

    for (i in changes) {
	var c = changes[i];
	pchanges.push({
	    element_name : i,
	    element_change : c.type + ": " + c.value,
	});
    }

    var order = {
	order_date : formatDate(),
	client_id : client_id,
	model_id : model_id,
	changes : pchanges,
    };
    
    console.log(order);
    
    $.ajax({
	method: 'POST',
	data: order,
	url: base_url + '/order',
	success: function(data) {
	    console.log(data);
	    window.location = order_url + '/show/' + data.transaction_id;
	}
    })
}