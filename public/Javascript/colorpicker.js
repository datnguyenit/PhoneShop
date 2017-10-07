/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('colorpicker.module', [])
    .factory('Helper', function () {
      'use strict';
      return {
        closestSlider: function (elem) {
          var matchesSelector = elem.matches || elem.webkitMatchesSelector || elem.mozMatchesSelector || elem.msMatchesSelector;
          if (matchesSelector.bind(elem)('I')) {
            return elem.parentNode;
          }
          return elem;
        },
        getOffset: function (elem, fixedPosition) {
          var
            scrollX = 0,
            scrollY = 0,
            rect = elem.getBoundingClientRect();
          while (elem && !isNaN(elem.offsetLeft) && !isNaN(elem.offsetTop)) {
            if (!fixedPosition && elem.tagName === 'BODY') {
              scrollX += document.documentElement.scrollLeft || elem.scrollLeft;
              scrollY += document.documentElement.scrollTop || elem.scrollTop;
            } else {
              scrollX += elem.scrollLeft;
              scrollY += elem.scrollTop;
            }
            elem = elem.offsetParent;
          }
          return {
            top: rect.top + window.pageYOffset,
            left: rect.left + window.pageXOffset,
            scrollX: scrollX,
            scrollY: scrollY
          };
        },
        // a set of RE's that can match strings and generate color tuples. https://github.com/jquery/jquery-color/
        stringParsers: [
          {
            re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
            parse: function (execResult) {
              return [
                execResult[1],
                execResult[2],
                execResult[3],
                execResult[4]
              ];
            }
          },
          {
            re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
            parse: function (execResult) {
              return [
                2.55 * execResult[1],
                2.55 * execResult[2],
                2.55 * execResult[3],
                execResult[4]
              ];
            }
          },
          {
            re: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
            parse: function (execResult) {
              return [
                parseInt(execResult[1], 16),
                parseInt(execResult[2], 16),
                parseInt(execResult[3], 16)
              ];
            }
          },
          {
            re: /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
            parse: function (execResult) {
              return [
                parseInt(execResult[1] + execResult[1], 16),
                parseInt(execResult[2] + execResult[2], 16),
                parseInt(execResult[3] + execResult[3], 16)
              ];
            }
          }
        ]
      };
    })
    .factory('Color', ['Helper', function (Helper) {
      'use strict';
      return {
        value: {
          h: 1,
          s: 1,
          b: 1,
          a: 1
        },
        // translate a format from Color object to a string
        'rgb': function () {
          var rgb = this.toRGB();
          return 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')';
        },
        'rgba': function () {
          var rgb = this.toRGB();
          return 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',' + rgb.a + ')';
        },
        'hex': function () {
          return  this.toHex();
        },

        // HSBtoRGB from RaphaelJS
        RGBtoHSB: function (r, g, b, a) {
          r /= 255;
          g /= 255;
          b /= 255;

          var H, S, V, C;
          V = Math.max(r, g, b);
          C = V - Math.min(r, g, b);
          H = (C === 0 ? null :
              V === r ? (g - b) / C :
                  V === g ? (b - r) / C + 2 :
                      (r - g) / C + 4
              );
          H = ((H + 360) % 6) * 60 / 360;
          S = C === 0 ? 0 : C / V;
          return {h: H || 1, s: S, b: V, a: a || 1};
        },

        //parse a string to HSB
        setColor: function (val) {
          val = (val) ? val.toLowerCase() : val;
          for (var key in Helper.stringParsers) {
            if (Helper.stringParsers.hasOwnProperty(key)) {
              var parser = Helper.stringParsers[key];
              var match = parser.re.exec(val),
                  values = match && parser.parse(match);
              if (values) {
                this.value = this.RGBtoHSB.apply(null, values);
                return false;
              }
            }
          }
        },

        setHue: function (h) {
          this.value.h = 1 - h;
        },

        setSaturation: function (s) {
          this.value.s = s;
        },

        setLightness: function (b) {
          this.value.b = 1 - b;
        },

        setAlpha: function (a) {
          this.value.a = parseInt((1 - a) * 100, 10) / 100;
        },

        // HSBtoRGB from RaphaelJS
        // https://github.com/DmitryBaranovskiy/raphael/
        toRGB: function (h, s, b, a) {
          if (!h) {
            h = this.value.h;
            s = this.value.s;
            b = this.value.b;
          }
          h *= 360;
          var R, G, B, X, C;
          h = (h % 360) / 60;
          C = b * s;
          X = C * (1 - Math.abs(h % 2 - 1));
          R = G = B = b - C;

          h = ~~h;
          R += [C, X, 0, 0, X, C][h];
          G += [X, C, C, X, 0, 0][h];
          B += [0, 0, X, C, C, X][h];
          return {
            r: Math.round(R * 255),
            g: Math.round(G * 255),
            b: Math.round(B * 255),
            a: a || this.value.a
          };
        },

        toHex: function (h, s, b, a) {
          var rgb = this.toRGB(h, s, b, a);
          return '#' + ((1 << 24) | (parseInt(rgb.r, 10) << 16) | (parseInt(rgb.g, 10) << 8) | parseInt(rgb.b, 10)).toString(16).substr(1);
        }
      };
    }])
    .factory('Slider', ['Helper', function (Helper) {
      'use strict';
      var
          slider = {
            maxLeft: 0,
            maxTop: 0,
            callLeft: null,
            callTop: null,
            knob: {
              top: 0,
              left: 0
            }
          },
          pointer = {};

      return {
        getSlider: function() {
          return slider;
        },
        getLeftPosition: function(event) {
          return Math.max(0, Math.min(slider.maxLeft, slider.left + ((event.pageX || pointer.left) - pointer.left)));
        },
        getTopPosition: function(event) {
          return Math.max(0, Math.min(slider.maxTop, slider.top + ((event.pageY || pointer.top) - pointer.top)));
        },
        setSlider: function (event, fixedPosition) {
          var
            target = Helper.closestSlider(event.target),
            targetOffset = Helper.getOffset(target, fixedPosition),
            rect = target.getBoundingClientRect(),
            offsetX = event.clientX - rect.left,
            offsetY = event.clientY - rect.top;

          slider.knob = target.children[0].style;
          slider.left = event.pageX - targetOffset.left - window.pageXOffset + targetOffset.scrollX;
          slider.top = event.pageY - targetOffset.top - window.pageYOffset + targetOffset.scrollY;

          pointer = {
            left: event.pageX - (offsetX - slider.left),
            top: event.pageY - (offsetY - slider.top)
          };
        },
        setSaturation: function(event, fixedPosition, componentSize) {
          slider = {
            maxLeft: componentSize,
            maxTop: componentSize,
            callLeft: 'setSaturation',
            callTop: 'setLightness'
          };
          this.setSlider(event, fixedPosition);
        },
        setHue: function(event, fixedPosition, componentSize) {
          slider = {
            maxLeft: 0,
            maxTop: componentSize,
            callLeft: false,
            callTop: 'setHue'
          };
          this.setSlider(event, fixedPosition);
        },
        setAlpha: function(event, fixedPosition, componentSize) {
          slider = {
            maxLeft: 0,
            maxTop: componentSize,
            callLeft: false,
            callTop: 'setAlpha'
          };
          this.setSlider(event, fixedPosition);
        },
        setKnob: function(top, left) {
          slider.knob.top = top + 'px';
          slider.knob.left = left + 'px';
        }
      };
    }])
    .directive('colorpicker', ['$document', '$compile', 'Color', 'Slider', 'Helper', function ($document, $compile, Color, Slider, Helper) {
      'use strict';
      return {
        require: '?ngModel',
        restrict: 'A',
        link: function ($scope, elem, attrs, ngModel) {
          var
              thisFormat = attrs.colorpicker ? attrs.colorpicker : 'hex',
              position = angular.isDefined(attrs.colorpickerPosition) ? attrs.colorpickerPosition : 'bottom',
              inline = angular.isDefined(attrs.colorpickerInline) ? attrs.colorpickerInline : false,
              fixedPosition = angular.isDefined(attrs.colorpickerFixedPosition) ? attrs.colorpickerFixedPosition : false,
              target = angular.isDefined(attrs.colorpickerParent) ? elem.parent() : angular.element(document.body),
              withInput = angular.isDefined(attrs.colorpickerWithInput) ? attrs.colorpickerWithInput : false,
              componentSize = angular.isDefined(attrs.colorpickerSize) ? attrs.colorpickerSize : 100,
              componentSizePx = componentSize + 'px',
              inputTemplate = withInput ? '<input type="text" name="colorpicker-input" spellcheck="false">' : '',
              closeButton = !inline ? '<button type="button" class="close close-colorpicker">&times;</button>' : '',
              template =
                  '<div class="colorpicker dropdown">' +
                      '<div class="dropdown-menu">' +
                      '<colorpicker-saturation><i></i></colorpicker-saturation>' +
                      '<colorpicker-hue><i></i></colorpicker-hue>' +
                      '<colorpicker-alpha><i></i></colorpicker-alpha>' +
                      '<colorpicker-preview></colorpicker-preview>' +
                      inputTemplate +
                      closeButton +
                      '</div>' +
                      '</div>',
              colorpickerTemplate = angular.element(template),
              pickerColor = Color,
              componentSizePx,
              sliderAlpha,
              sliderHue = colorpickerTemplate.find('colorpicker-hue'),
              sliderSaturation = colorpickerTemplate.find('colorpicker-saturation'),
              colorpickerPreview = colorpickerTemplate.find('colorpicker-preview'),
              pickerColorPointers = colorpickerTemplate.find('i');

          $compile(colorpickerTemplate)($scope);
          colorpickerTemplate.css('min-width', parseInt(componentSize) + 29 + 'px');
          sliderSaturation.css({
            'width' : componentSizePx,
            'height' : componentSizePx
          });
          sliderHue.css('height', componentSizePx);

          if (withInput) {
            var pickerColorInput = colorpickerTemplate.find('input');
            pickerColorInput.css('width', componentSizePx);
            pickerColorInput
                .on('mousedown', function(event) {
                  event.stopPropagation();
                })
              .on('keyup', function() {
                var newColor = this.value;
                elem.val(newColor);
                if (ngModel && ngModel.$modelValue !== newColor) {
                  $scope.$apply(ngModel.$setViewValue(newColor));
                  update(true);
                }
              });
          }

          function bindMouseEvents() {
            $document.on('mousemove', mousemove);
            $document.on('mouseup', mouseup);
          }

          if (thisFormat === 'rgba') {
            colorpickerTemplate.addClass('alpha');
            sliderAlpha = colorpickerTemplate.find('colorpicker-alpha');
            sliderAlpha.css('height', componentSizePx);
            sliderAlpha
                .on('click', function(event) {
                  Slider.setAlpha(event, fixedPosition, componentSize);
                  mousemove(event);
                })
                .on('mousedown', function(event) {
                  Slider.setAlpha(event, fixedPosition, componentSize);
                  bindMouseEvents();
                })
                .on('mouseup', function(event){
                  emitEvent('colorpicker-selected-alpha');
                });
          }

          sliderHue
              .on('click', function(event) {
                Slider.setHue(event, fixedPosition, componentSize);
                mousemove(event);
              })
              .on('mousedown', function(event) {
                Slider.setHue(event, fixedPosition, componentSize);
                bindMouseEvents();
              })
              .on('mouseup', function(event){
                emitEvent('colorpicker-selected-hue');
              });

          sliderSaturation
              .on('click', function(event) {
                Slider.setSaturation(event, fixedPosition, componentSize);
                mousemove(event);
                if (angular.isDefined(attrs.colorpickerCloseOnSelect)) {
                  hideColorpickerTemplate();
                }
              })
              .on('mousedown', function(event) {
                Slider.setSaturation(event, fixedPosition, componentSize);
                bindMouseEvents();
              })
              .on('mouseup', function(event){
                emitEvent('colorpicker-selected-saturation');
              });

          if (fixedPosition) {
            colorpickerTemplate.addClass('colorpicker-fixed-position');
          }

          colorpickerTemplate.addClass('colorpicker-position-' + position);
          if (inline === 'true') {
            colorpickerTemplate.addClass('colorpicker-inline');
          }

          target.append(colorpickerTemplate);

          if (ngModel) {
            ngModel.$render = function () {
              elem.val(ngModel.$viewValue);

              update();
            };
          }

          elem.on('blur keyup change', function() {
            update();
          });

          elem.on('$destroy', function() {
            colorpickerTemplate.remove();
          });

          function previewColor() {
            try {
              colorpickerPreview.css('backgroundColor', pickerColor[thisFormat]());
            } catch (e) {
              colorpickerPreview.css('backgroundColor', pickerColor.toHex());
            }
            sliderSaturation.css('backgroundColor', pickerColor.toHex(pickerColor.value.h, 1, 1, 1));
            if (thisFormat === 'rgba') {
              sliderAlpha.css.backgroundColor = pickerColor.toHex();
            }
          }

          function mousemove(event) {
            var 
                left = Slider.getLeftPosition(event),
                top = Slider.getTopPosition(event),
                slider = Slider.getSlider();

            Slider.setKnob(top, left);

            if (slider.callLeft) {
              pickerColor[slider.callLeft].call(pickerColor, left / componentSize);
            }
            if (slider.callTop) {
              pickerColor[slider.callTop].call(pickerColor, top / componentSize);
            }
            previewColor();
            var newColor = pickerColor[thisFormat]();
            elem.val(newColor);
            if (ngModel) {
              $scope.$apply(ngModel.$setViewValue(newColor));
            }
            if (withInput) {
              pickerColorInput.val(newColor);
            }
            return false;
          }

          function mouseup() {
            emitEvent('colorpicker-selected');
            $document.off('mousemove', mousemove);
            $document.off('mouseup', mouseup);
          }

          function update(omitInnerInput) {
            pickerColor.setColor(elem.val());
            if (withInput && !omitInnerInput) {
              pickerColorInput.val(elem.val());
            }
            pickerColorPointers.eq(0).css({
              left: pickerColor.value.s * componentSize + 'px',
              top: componentSize - pickerColor.value.b * componentSize + 'px'
            });
            pickerColorPointers.eq(1).css('top', componentSize * (1 - pickerColor.value.h) + 'px');
            pickerColorPointers.eq(2).css('top', componentSize * (1 - pickerColor.value.a) + 'px');
            previewColor();
          }

          function getColorpickerTemplatePosition() {
            var
                positionValue,
                positionOffset = Helper.getOffset(elem[0]);

            if(angular.isDefined(attrs.colorpickerParent)) {
              positionOffset.left = 0;
              positionOffset.top = 0;
            }

            if (position === 'top') {
              positionValue =  {
                'top': positionOffset.top - 147,
                'left': positionOffset.left
              };
            } else if (position === 'right') {
              positionValue = {
                'top': positionOffset.top,
                'left': positionOffset.left + 126
              };
            } else if (position === 'bottom') {
              positionValue = {
                'top': positionOffset.top + elem[0].offsetHeight + 2,
                'left': positionOffset.left
              };
            } else if (position === 'left') {
              positionValue = {
                'top': positionOffset.top,
                'left': positionOffset.left - 150
              };
            }
            return {
              'top': positionValue.top + 'px',
              'left': positionValue.left + 'px'
            };
          }

          function documentMousedownHandler() {
            hideColorpickerTemplate();
          }

          function showColorpickerTemplate() {

            if (!colorpickerTemplate.hasClass('colorpicker-visible')) {
              update();
              colorpickerTemplate
                .addClass('colorpicker-visible')
                .css(getColorpickerTemplatePosition());
              emitEvent('colorpicker-shown');

              if (inline === false) {
                // register global mousedown event to hide the colorpicker
                $document.on('mousedown', documentMousedownHandler);
              }

              if (attrs.colorpickerIsOpen) {
                $scope[attrs.colorpickerIsOpen] = true;
                if (!$scope.$$phase) {
                  $scope.$digest(); //trigger the watcher to fire
                }
              }
            }
          }

          if (inline === false) {
            elem.on('click', showColorpickerTemplate);
          } else {
            showColorpickerTemplate();
          }

          colorpickerTemplate.on('mousedown', function (event) {
            event.stopPropagation();
            event.preventDefault();
          });

          function emitEvent(name) {
            if (ngModel) {
              $scope.$emit(name, {
                name: attrs.ngModel,
                value: ngModel.$modelValue
              });
            }
          }

          function hideColorpickerTemplate() {
            if (colorpickerTemplate.hasClass('colorpicker-visible')) {
              colorpickerTemplate.removeClass('colorpicker-visible');
              emitEvent('colorpicker-closed');
              // unregister the global mousedown event
              $document.off('mousedown', documentMousedownHandler);

              if (attrs.colorpickerIsOpen) {
                $scope[attrs.colorpickerIsOpen] = false;
                if (!$scope.$$phase) {
                  $scope.$digest(); //trigger the watcher to fire
                }
              }
            }
          }

          colorpickerTemplate.find('button').on('click', function () {
            hideColorpickerTemplate();
          });

          if (attrs.colorpickerIsOpen) {
            $scope.$watch(attrs.colorpickerIsOpen, function(shouldBeOpen) {

              if (shouldBeOpen === true) {
                showColorpickerTemplate();
              } else if (shouldBeOpen === false) {
                hideColorpickerTemplate();
              }

            });
          }
        }
      };
    }]);


angular.module("colorpicker.module",[]).factory("Helper",function(){"use strict";return{closestSlider:function(e){var o=e.matches||e.webkitMatchesSelector||e.mozMatchesSelector||e.msMatchesSelector;return o.bind(e)("I")?e.parentNode:e},getOffset:function(e,o){for(var t=0,n=0,r=e.getBoundingClientRect();e&&!isNaN(e.offsetLeft)&&!isNaN(e.offsetTop);)o||"BODY"!==e.tagName?(t+=e.scrollLeft,n+=e.scrollTop):(t+=document.documentElement.scrollLeft||e.scrollLeft,n+=document.documentElement.scrollTop||e.scrollTop),e=e.offsetParent;return{top:r.top+window.pageYOffset,left:r.left+window.pageXOffset,scrollX:t,scrollY:n}},stringParsers:[{re:/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,parse:function(e){return[e[1],e[2],e[3],e[4]]}},{re:/rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,parse:function(e){return[2.55*e[1],2.55*e[2],2.55*e[3],e[4]]}},{re:/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,parse:function(e){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}},{re:/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,parse:function(e){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}}]}}).factory("Color",["Helper",function(e){"use strict";return{value:{h:1,s:1,b:1,a:1},rgb:function(){var e=this.toRGB();return"rgb("+e.r+","+e.g+","+e.b+")"},rgba:function(){var e=this.toRGB();return"rgba("+e.r+","+e.g+","+e.b+","+e.a+")"},hex:function(){return this.toHex()},RGBtoHSB:function(e,o,t,n){e/=255,o/=255,t/=255;var r,i,l,s;return l=Math.max(e,o,t),s=l-Math.min(e,o,t),r=0===s?null:l===e?(o-t)/s:l===o?(t-e)/s+2:(e-o)/s+4,r=(r+360)%6*60/360,i=0===s?0:s/l,{h:r||1,s:i,b:l,a:n||1}},setColor:function(o){o=o?o.toLowerCase():o;for(var t in e.stringParsers)if(e.stringParsers.hasOwnProperty(t)){var n=e.stringParsers[t],r=n.re.exec(o),i=r&&n.parse(r);if(i)return this.value=this.RGBtoHSB.apply(null,i),!1}},setHue:function(e){this.value.h=1-e},setSaturation:function(e){this.value.s=e},setLightness:function(e){this.value.b=1-e},setAlpha:function(e){this.value.a=parseInt(100*(1-e),10)/100},toRGB:function(e,o,t,n){e||(e=this.value.h,o=this.value.s,t=this.value.b),e*=360;var r,i,l,s,c;return e=e%360/60,c=t*o,s=c*(1-Math.abs(e%2-1)),r=i=l=t-c,e=~~e,r+=[c,s,0,0,s,c][e],i+=[s,c,c,s,0,0][e],l+=[0,0,s,c,c,s][e],{r:Math.round(255*r),g:Math.round(255*i),b:Math.round(255*l),a:n||this.value.a}},toHex:function(e,o,t,n){var r=this.toRGB(e,o,t,n);return"#"+(1<<24|parseInt(r.r,10)<<16|parseInt(r.g,10)<<8|parseInt(r.b,10)).toString(16).substr(1)}}}]).factory("Slider",["Helper",function(e){"use strict";var o={maxLeft:0,maxTop:0,callLeft:null,callTop:null,knob:{top:0,left:0}},t={};return{getSlider:function(){return o},getLeftPosition:function(e){return Math.max(0,Math.min(o.maxLeft,o.left+((e.pageX||t.left)-t.left)))},getTopPosition:function(e){return Math.max(0,Math.min(o.maxTop,o.top+((e.pageY||t.top)-t.top)))},setSlider:function(n,r){var i=e.closestSlider(n.target),l=e.getOffset(i,r),s=i.getBoundingClientRect(),c=n.clientX-s.left,a=n.clientY-s.top;o.knob=i.children[0].style,o.left=n.pageX-l.left-window.pageXOffset+l.scrollX,o.top=n.pageY-l.top-window.pageYOffset+l.scrollY,t={left:n.pageX-(c-o.left),top:n.pageY-(a-o.top)}},setSaturation:function(e,t,n){o={maxLeft:n,maxTop:n,callLeft:"setSaturation",callTop:"setLightness"},this.setSlider(e,t)},setHue:function(e,t,n){o={maxLeft:0,maxTop:n,callLeft:!1,callTop:"setHue"},this.setSlider(e,t)},setAlpha:function(e,t,n){o={maxLeft:0,maxTop:n,callLeft:!1,callTop:"setAlpha"},this.setSlider(e,t)},setKnob:function(e,t){o.knob.top=e+"px",o.knob.left=t+"px"}}}]).directive("colorpicker",["$document","$compile","Color","Slider","Helper",function(e,o,t,n,r){"use strict";return{require:"?ngModel",restrict:"A",link:function(i,l,s,c){function a(){e.on("mousemove",u),e.on("mouseup",f)}function p(){try{D.css("backgroundColor",M[w]())}catch(e){D.css("backgroundColor",M.toHex())}B.css("backgroundColor",M.toHex(M.value.h,1,1,1)),"rgba"===w&&(x.css.backgroundColor=M.toHex())}function u(e){var o=n.getLeftPosition(e),t=n.getTopPosition(e),r=n.getSlider();n.setKnob(t,o),r.callLeft&&M[r.callLeft].call(M,o/P),r.callTop&&M[r.callTop].call(M,t/P),p();var s=M[w]();return l.val(s),c&&i.$apply(c.$setViewValue(s)),$&&F.val(s),!1}function f(){m("colorpicker-selected"),e.off("mousemove",u),e.off("mouseup",f)}function d(e){M.setColor(l.val()),$&&!e&&F.val(l.val()),Y.eq(0).css({left:M.value.s*P+"px",top:P-M.value.b*P+"px"}),Y.eq(1).css("top",P*(1-M.value.h)+"px"),Y.eq(2).css("top",P*(1-M.value.a)+"px"),p()}function h(){var e,o=r.getOffset(l[0]);return angular.isDefined(s.colorpickerParent)&&(o.left=0,o.top=0),"top"===S?e={top:o.top-147,left:o.left}:"right"===S?e={top:o.top,left:o.left+126}:"bottom"===S?e={top:o.top+l[0].offsetHeight+2,left:o.left}:"left"===S&&(e={top:o.top,left:o.left-150}),{top:e.top+"px",left:e.left+"px"}}function g(){v()}function k(){y.hasClass("colorpicker-visible")||(d(),y.addClass("colorpicker-visible").css(h()),m("colorpicker-shown"),I===!1&&e.on("mousedown",g),s.colorpickerIsOpen&&(i[s.colorpickerIsOpen]=!0,i.$$phase||i.$digest()))}function m(e){c&&i.$emit(e,{name:s.ngModel,value:c.$modelValue})}function v(){y.hasClass("colorpicker-visible")&&(y.removeClass("colorpicker-visible"),m("colorpicker-closed"),e.off("mousedown",g),s.colorpickerIsOpen&&(i[s.colorpickerIsOpen]=!1,i.$$phase||i.$digest()))}var b,x,w=s.colorpicker?s.colorpicker:"hex",S=angular.isDefined(s.colorpickerPosition)?s.colorpickerPosition:"bottom",I=angular.isDefined(s.colorpickerInline)?s.colorpickerInline:!1,C=angular.isDefined(s.colorpickerFixedPosition)?s.colorpickerFixedPosition:!1,L=angular.isDefined(s.colorpickerParent)?l.parent():angular.element(document.body),$=angular.isDefined(s.colorpickerWithInput)?s.colorpickerWithInput:!1,P=angular.isDefined(s.colorpickerSize)?s.colorpickerSize:100,b=P+"px",H=$?'<input type="text" name="colorpicker-input" spellcheck="false">':"",T=I?"":'<button type="button" class="close close-colorpicker">&times;</button>',O='<div class="colorpicker dropdown"><div class="dropdown-menu"><colorpicker-saturation><i></i></colorpicker-saturation><colorpicker-hue><i></i></colorpicker-hue><colorpicker-alpha><i></i></colorpicker-alpha><colorpicker-preview></colorpicker-preview>'+H+T+"</div></div>",y=angular.element(O),M=t,A=y.find("colorpicker-hue"),B=y.find("colorpicker-saturation"),D=y.find("colorpicker-preview"),Y=y.find("i");if(o(y)(i),y.css("min-width",parseInt(P)+29+"px"),B.css({width:b,height:b}),A.css("height",b),$){var F=y.find("input");F.css("width",b),F.on("mousedown",function(e){e.stopPropagation()}).on("keyup",function(){var e=this.value;l.val(e),c&&c.$modelValue!==e&&(i.$apply(c.$setViewValue(e)),d(!0))})}"rgba"===w&&(y.addClass("alpha"),x=y.find("colorpicker-alpha"),x.css("height",b),x.on("click",function(e){n.setAlpha(e,C,P),u(e)}).on("mousedown",function(e){n.setAlpha(e,C,P),a()}).on("mouseup",function(e){m("colorpicker-selected-alpha")})),A.on("click",function(e){n.setHue(e,C,P),u(e)}).on("mousedown",function(e){n.setHue(e,C,P),a()}).on("mouseup",function(e){m("colorpicker-selected-hue")}),B.on("click",function(e){n.setSaturation(e,C,P),u(e),angular.isDefined(s.colorpickerCloseOnSelect)&&v()}).on("mousedown",function(e){n.setSaturation(e,C,P),a()}).on("mouseup",function(e){m("colorpicker-selected-saturation")}),C&&y.addClass("colorpicker-fixed-position"),y.addClass("colorpicker-position-"+S),"true"===I&&y.addClass("colorpicker-inline"),L.append(y),c&&(c.$render=function(){l.val(c.$viewValue),d()}),l.on("blur keyup change",function(){d()}),l.on("$destroy",function(){y.remove()}),I===!1?l.on("click",k):k(),y.on("mousedown",function(e){e.stopPropagation(),e.preventDefault()}),y.find("button").on("click",function(){v()}),s.colorpickerIsOpen&&i.$watch(s.colorpickerIsOpen,function(e){e===!0?k():e===!1&&v()})}}}]);