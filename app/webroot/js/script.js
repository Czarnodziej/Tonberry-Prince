/* Two separate functions loaded on DOM load - one with plain JS, one with jQuery support,
   because not all subpages use jQuery (subject to change). And messing with separate scripts for each page is
   not DRY enough for my taste. A good taste.*/


  "use strict"; //jslint compatibility
  var mobilBGAttachFix, //fixes backgroundAttachment=fixed in mobile web browsers (esp. android)
      przycisk;
    mobilBGAttachFix = function() {
      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|Opera Mini|IEMobile/i.test(navigator.userAgent)) {
        document.body.style.backgroundAttachment = "scroll"; //user agent sniffing is bad, todo: better solution
      }
    };

  przycisk = function() { //fixes backgroundAttachment=fixed in mobile web browsers (esp. android)
    var button = document.getElementById('button');
    button.onclick = function() {
      var skillVis = document.getElementById('skills') || document.getElementById('skillsv'); //finds both states of the button
      if (skillVis.id === 'skills') {
        skillVis.id = 'skillsv';
        button.textContent = 'Wróć do samych gwiazdek';
      } else {
        skillVis.id = 'skills';
        button.textContent = 'Pokaż sensowniejszy opis';
      }
    };
  };

  if (document.getElementById('skills') !== null) { //only if #skills is present in the document
    przycisk();
  }
  mobilBGAttachFix();

$(function() {
  "use strict"; //jslint compatibility
  /* Polish initialisation for the jQuery UI date picker plugin.
   Written by Jacek Wysocki (jacek.wysocki@gmail.com).
   Modified by Marcin Mongiało (pagodemc@gmail.com). */
  
  $.datepicker.regional.pl = { //dot notation all the way
    closeText: 'Zamknij',
    prevText: '&#x3c;Poprzedni',
    nextText: 'Następny&#x3e;',
    currentText: 'Dziś',
    monthNames: ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca',
      'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'], //righteous grammar fixes
    monthNamesShort: ['Sty', 'Lu', 'Mar', 'Kw', 'Maj', 'Cze',
      'Lip', 'Sie', 'Wrz', 'Pa', 'Lis', 'Gru'],
    dayNames: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
    dayNamesShort: ['Nie', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So'],
    dayNamesMin: ['N', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
    weekHeader: 'Tydz',
    dateFormat: 'DD, d MM yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''};
  $.datepicker.setDefaults($.datepicker.regional.pl);

  $("#datepicker")
          .datepicker({
    autoSize: true,
    regional: "pl",
    showWeek: true,
    showOtherMonths: true,
    selectOtherMonths: true,
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    yearRange: "1982:2032"
  });
  $(document)
          .tooltip({
    track: true
  });
  var tabs = $("#tabs")
          .tabs();
  tabs.find(".ui-tabs-nav")
          .sortable({
    axis: "x",
    stop: function() {
      tabs.tabs("refresh");
    }
  });
  $('#tabs').css('visibility', 'visible'); //makes jQueryUI tabs visible after script executes to avoid FOUC. FOUC are bad!
});