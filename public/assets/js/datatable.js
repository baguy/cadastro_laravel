var AdminTR = AdminTR || {};

AdminTR.DataTable = (function() {

  function DataTable(resource, $_container, $_form = null) {

    this.resource  = resource;
    this.container = $_container;
    this.form      = ($_form) ? $_form.serialize() : $_form;
    this.error     = this.container.data('datatable-error')
    this.pagelink  = null;
    this.appurl    = $('body').data('url');
    this.url       = `${this.appurl}/list/${this.resource}`;
  }

  DataTable.prototype.initialize = function() {

    getContent.call(this, this.url);
  }

  function getContent(url) {

    loading.call(this, this.container);

    $.ajax({
      url: url,
      type: 'GET',
      data: this.form,
      success: onSuccess.bind(this),
      error: onError.bind(this),
    });

  }

  function navigate(e) {

  	e.preventDefault();

    getContent.call(this, $(e.currentTarget).attr('href'));
  }

  function loading(target) {

	  var loading = $('<div>').attr({'class': 'text-center text-info'}),
	      icon    = $('<i>').attr({'class': 'fas fa-circle-notch fa-spin fa-5x'});

	  loading.append(icon);

	  target.html(loading);
	}

	function onSuccess(data) {

    this.container.html(data);


    this.pagelink = $('ul.pagination').children('li.page-item').children('a.page-link');

    this.pagelink.on('click', navigate.bind(this));

    // Tooltip Reinitialization
    $('[data-tooltip="tooltip"]').tooltip();

    // Table Description Initialize
    var tableDescription = new AdminTR.TableDescription();

  	tableDescription.initialize();
  }

	function onError(jqXHR, exception) {

    this.container
        			.html(`<div class="alert alert-danger">${this.error}</div>`);
  }

  return DataTable;

}());
