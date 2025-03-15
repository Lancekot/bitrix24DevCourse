/* eslint-disable */
this.BX = this.BX || {};
(function (exports,main_core) {
	'use strict';

	var ColorMyTask = /*#__PURE__*/function () {
	  function ColorMyTask() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      name: 'ColorMyTask'
	    };
	    babelHelpers.classCallCheck(this, ColorMyTask);
	    this.name = options.name;
	  }
	  babelHelpers.createClass(ColorMyTask, [{
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
	  }]);
	  return ColorMyTask;
	}();

	exports.ColorMyTask = ColorMyTask;

}((this.BX.Tasks = this.BX.Tasks || {}),BX));
//# sourceMappingURL=color-my-task.bundle.js.map
