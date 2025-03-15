/* eslint-disable */
this.BX = this.BX || {};
(function (exports,main_core) {
	'use strict';

	var CheckControlOpenWorkDay = /*#__PURE__*/function () {
	  function CheckControlOpenWorkDay() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      name: 'CheckControlOpenWorkDay'
	    };
	    babelHelpers.classCallCheck(this, CheckControlOpenWorkDay);
	    this.name = options.name;
	  }
	  babelHelpers.createClass(CheckControlOpenWorkDay, [{
	    key: "setName",
	    value: function setName(name) {
	      if (main_core.Type.isString(name)) {
	        this.name = name;
	      }
	    }
	  }, {
	    key: "getName",
	    value: function getName() {
	      return this.name;
	    }
	  }, {
	    key: "getConsole",
	    value: function getConsole() {
	      console.log("Все работает");
	    }
	  }]);
	  return CheckControlOpenWorkDay;
	}();

	exports.CheckControlOpenWorkDay = CheckControlOpenWorkDay;

}((this.BX.Timeman = this.BX.Timeman || {}),BX));
//# sourceMappingURL=check-control-open-work-day.bundle.js.map
