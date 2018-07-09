StagemSysConfig = {
  body: $('body'),

  onlyOnce: {},

  attachEvents: function () {
    this.attachOnConfigLoad();
  },

  attachOnConfigLoad: function () {
    // Remove handler from existing elements
    this.body.off('change', '#system .checkbox input', this.disableElement);

    // Re-add event handler for all matching elements
    this.body.on('change', '#system .checkbox input', this.disableElement);
  },

  disableElement: function () {
    var input = $(this).closest('.form-group').find('input:not(:hidden)').filter(':not(:last)');
    this.checked ? input.prop('disabled', true) : input.prop('disabled', false);
  }

};

jQuery(document).ready(function ($) {
  // disable all elements which marked for default usage
  $('#system .checkbox input:checked').each(function() {
    StagemSysConfig.disableElement.bind(this)();
  });

  StagemSysConfig.attachEvents();

  /*$(document).on('shown.bs.modal', function (e) {
    AgereDatePicker.attachEvents(); // reattach print barcode button
  });*/

});