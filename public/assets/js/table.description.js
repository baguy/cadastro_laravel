var AdminTR = AdminTR || {};

AdminTR.TableDescription = (function(){

  function TableDescription() {

    this.collapseAll = $(".th-collapse-all");
    this.tdDescription = $('td.description');
    this.btnToggle = $(".btn-toggle");
    this.tableCollapse = $(".table-collapse");

    this.showHide = null;
    this.isCollapse = false;
  }

  TableDescription.prototype.initialize = function() {

    this.collapseAll.on('click', collapseAllOnClick.bind(this));
    this.btnToggle.on('click', btnToggleOnClick);

    setInitialParameters.call(this);
  }

  function collapseAllOnClick() {

    this.collapseAll.children('i.fa-expand').toggleClass('d-none');
    this.collapseAll.children('i.fa-compress').toggleClass('d-none');

    if (this.isCollapse) {

      setCollapseAllParameters.call(this, 'hide', false, 'fa-plus', 'fa-minus');

    } else {

      setCollapseAllParameters.call(this, 'show', true, 'fa-minus', 'fa-plus');
    }

    this.tdDescription.children('div.collapse').collapse(this.showHide);
  }

  function btnToggleOnClick() {

    $(this).children('i').toggleClass('fa-plus fa-minus');
  }

  function setInitialParameters() {

    var cssAttribute = { "width": "56px" };
    var cssAttributes = { "height": "0px", "padding": "0px", "margin": "0px" };

    this.tdDescription.children('div.collapse').collapse('hide');
    this.tdDescription.children('div.collapse.shown').collapse('show');
    this.btnToggle.closest('td').css(cssAttribute);
    this.tdDescription.css(cssAttributes).attr('colspan', this.tableCollapse.find("th").length);
  }

  function setCollapseAllParameters(showHide, isCollapse, addClass, removeClass) {

    this.showHide = showHide;
    this.isCollapse = isCollapse;
    this.btnToggle.children('i').addClass(addClass);
    this.btnToggle.children('i').removeClass(removeClass);
  }

  return TableDescription;

}());

// $(function(){
//
//   var tableDescription = new AdmIntr.TableDescription();
//
//   tableDescription.initialize();
// });
