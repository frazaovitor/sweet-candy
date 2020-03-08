<?php
class Rsc_Html {
    static public function nameToClassId($name, $params = array()) {
		if(!empty($params) && isset($params['attrs']) && strpos($params['attrs'], 'id="') !== false) {
			preg_match('/id="(.+)"/ui', $params['attrs'], $idMatches);
			if($idMatches[1]) {
				return $idMatches[1];
			}
		}
        return str_replace(array('[', ']'), '', $name);
    }
    static public function textarea($name, $params = array('attrs' => '', 'value' => '', 'rows' => 3, 'cols' => 50)) {
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $params['rows'] = isset($params['rows']) ? $params['rows'] : 3;
        $params['cols'] = isset($params['cols']) ? $params['cols'] : 50;
		if(
			isset($params['required'])
			&& $params['required']
			&& (!isset($params['customValidation']) || !$params['customValidation'])
		) {
			$params['attrs'] .= ' required ';	// HTML5 "required" validation attr
		}
		if(isset($params['placeholder']) && $params['placeholder']) {
			$params['attrs'] .= ' placeholder="'. $params['placeholder']. '"';	// HTML5 "required" validation attr
		}
		if(isset($params['disabled']) && $params['disabled']) {
			$params['attrs'] .= ' disabled ';
		}
		if(isset($params['readonly']) && $params['readonly']) {
			$params['attrs'] .= ' readonly ';
		}
		if(isset($params['min']) && !empty($params['min'])) {
			$params['attrs'] .= '  minlength="'. $params['min']. '"';
		}
		if(isset($params['max']) && !empty($params['max'])) {
			$params['attrs'] .= ' maxlength="'. $params['max']. '"';
		}
		if(isset($params['pattern']) && !empty($params['pattern'])) {
			$params['attrs'] .= ' pattern="'. $params['pattern']. '"';
		}
		if(isset($params['auto_width']) && $params['auto_width']) {
			unset($params['rows']);
			unset($params['cols']);
		}
        return '<textarea name="'. $name. '" '
			. (isset($params['attrs']) ? $params['attrs'] : '')
			. (isset($params['rows']) ? ' rows="'. $params['rows']. '"' : '')
			. (isset($params['cols']) ? ' cols="'. $params['cols']. '"' : '')
			. '>'.
			(isset($params['value']) ? $params['value'] : '').
		'</textarea>';
    }
    static public function input($name, $params = array('attrs' => '', 'type' => 'text', 'value' => '')) {
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['attrs'] .= self::_dataToAttrs($params);
		if(
			isset($params['required'])
			&& $params['required']
			&& (!isset($params['customValidation']) || !$params['customValidation'])
		) {
			$params['attrs'] .= ' required ';	// HTML5 "required" validation attr
		}
		if(isset($params['placeholder']) && $params['placeholder']) {
			$params['attrs'] .= ' placeholder="'. $params['placeholder']. '"';	// HTML5 "required" validation attr
		}
		if(isset($params['disabled']) && $params['disabled']) {
			$params['attrs'] .= ' disabled ';
		}
		if(isset($params['readonly']) && $params['readonly']) {
			$params['attrs'] .= ' readonly ';
		}
		if(isset($params['min']) && !empty($params['min'])) {
			$params['attrs'] .= ' min="'. $params['min']. '"';
		}
		if(isset($params['max']) && !empty($params['max'])) {
			$params['attrs'] .= ' max="'. $params['max']. '"';
		}
		if(isset($params['pattern']) && !empty($params['pattern'])) {
			$params['attrs'] .= ' pattern="'. $params['pattern']. '"';
		}
		$params['value'] = isset($params['value']) ? $params['value'] : '';
        return '<input type="'. $params['type']. '" name="'. $name. '" value="'. $params['value']. '" '. (isset($params['attrs']) ? $params['attrs'] : ''). ' />';
    }
	static private function _dataToAttrs($params) {
		$res = '';
		foreach($params as $k => $v) {
			if(strpos($k, 'data-') === 0) {
				$res .= ' '. $k. '="'. $v. '"';
			}
		}
		return $res;
	}
    static public function text($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'text';
        return self::input($name, $params);
    }
	static public function email($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'email';
        return self::input($name, $params);
    }
	static public function reset($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'reset';
        return self::input($name, $params);
    }
    static public function password($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'password';
        return self::input($name, $params);
    }
    static public function hidden($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'hidden';
        return self::input($name, $params);
    }
	static public function number($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'number';
        return self::input($name, $params);
    }
	static public function date($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'date';
        return self::input($name, $params);
    }
	static public function month($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'month';
        return self::input($name, $params);
    }
	static public function week($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'week';
        return self::input($name, $params);
    }
	static public function time($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'time';
        return self::input($name, $params);
    }
	static public function datetime($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'datetime';
        return self::input($name, $params);
    }
	static public function color($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'color';
        return self::input($name, $params);
    }
	static public function range($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'range';
        return self::input($name, $params);
    }
	static public function url($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'url';
        return self::input($name, $params);
    }
    static public function checkbox($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
        $params['type'] = 'checkbox';
        if(isset($params['checked']) && $params['checked'])
            $params['checked'] = 'checked';
        if(!isset($params['value']) || $params['value'] === NULL)
            $params['value'] = 1;
		if(!isset($params['attrs']))
			$params['attrs'] = '';
        $params['attrs'] .= ' '. (isset($params['checked']) ? $params['checked'] : '');
        return self::input($name, $params);
    }
    static public function checkboxlist($name, $params = array('options' => array(), 'attrs' => '')) {
        if(!strpos($name, '[]')) {
            $name .= '[]';
        }
		return self::_generateCheckList($name, $params, array('self', 'checkbox'), array('self', '_checkInArray'));
    }
	static private function _checkInArray($checkIn, $key) {
		return $checkIn && in_array($key, $checkIn);
	}
	static private function _checkEqual($checkIn, $key) {
		return $checkIn !== false && $checkIn == $key;
	}
	static private function _generateCheckList($name, $params, $htmlClb, $checkedClb) {
		$out = '';
		if(isset($params['options']) && $params['options']) {
			$params['value'] = isset($params['value']) ? $params['value'] : false;
			$params['display'] = isset($params['display']) ? $params['display'] : 'row';
			foreach($params['options'] as $k => $val) {
				$checked = call_user_func_array($checkedClb, array($params['value'], $k));
				$attrs = isset($params['attrs']) ? $params['attrs'] : '';
				$id = 'cfsCheckRandId_'. mt_rand(1, 99999);
				$attrs .= ' id="'. $id. '"';
				$inputHtml = call_user_func_array($htmlClb, array($name, array(
					'attrs' => $attrs,
                    'value' => $k,
                    'checked' => $checked,
				)));
				if($params['display'] == 'row') {
					$out .= '<div class="field"><div class="'. $params['class_type']. '">'. $inputHtml. '<label for="'. $id. '">'. ''. $val. '</label></div></div>';
				} elseif($params['display'] == 'col') {
					$out .= '<tr><td>'. $inputHtml. '</td><td><label for="'. $id. '">'. $val. '</label></td></tr>';
				}
			}
			if($params['display'] == 'col') {
				$out = '<table class="cfsCheckTbl">'. $out. '</table>';
			}
        }
		return $out;
	}
	static public function timepicker($name, $params = array('attrs' => '', 'value' => '')) {
		if(isset($params['id']) && !empty($params['id']))
            $id = $params['id'];
        else
            $id = self::nameToClassId($name);
		return self::input($name, array(
                'attrs' => 'id="'. $id. '" '. (isset($params['attrs']) ? $params['attrs'] : ''),
                'type' => 'text',
                'value' => $params['value']
        )).'<script type="text/javascript">
            // <!--
                jQuery(document).ready(function(){
                    jQuery("#'. $id. '").timepicker('. json_encode($params). ');
                });
            // -->
        </script>';
	}
    static public function datepicker($name, $params = array('attrs' => '', 'value' => '')) {
        if(isset($params['id']) && !empty($params['id']))
            $id = $params['id'];
        else
            $id = self::nameToClassId($name);
		$params = array_merge(array(
			'changeYear' => true,
			'yearRange' => '1905:'. (date('Y')+5),
		), $params);
        return self::input($name, array(
                'attrs' => 'id="'. $id. '" placeholder="'. $params['format']['text']. '"'. (isset($params['attrs']) ? $params['attrs'] : ''),
                'type' => 'text',
                'value' => isset($params['value']) ? $params['value'] : ''
        )).'<script type="text/javascript">
            // <!--
				jQuery(document).ready(function(){
			
					var picker = new Pikaday({
						field: jQuery("#'. $id. '")[0],
						format: jQuery("#'. $id. '").attr("'. $params['format']['value']. '"),
						onSelect: function() {
							jQuery("#'. $id. '")[0].value = picker.toString("'. $params['format']['value']. '");
						}
					});
				});
            // -->
        </script>';
    }
    static public function submit($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'submit';
        return self::input($name, $params);
    }
    static public function img($src, $usePlugPath = 1, $params = array('width' => '', 'height' => '', 'attrs' => '')) {
        if($usePlugPath) $src = CFS_IMG_PATH. $src;
        return '<img src="'.$src.'" '
				.(isset($params['width']) ? 'width="'.$params['width'].'"' : '')
				.' '
				.(isset($params['height']) ? 'height="'.$params['height'].'"' : '')
				.' '
				.(isset($params['attrs']) ? $params['attrs'] : '').' />';
    }
    static public function selectbox($name, $params = array('attrs' => '', 'options' => array(), 'value' => '')) {
        $out = '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['attrs'] .= self::_dataToAttrs($params);
		if(
			isset($params['required'])
			&& $params['required']
			&& (!isset($params['customValidation']) || !$params['customValidation'])
		) {
			$params['attrs'] .= ' required ';	// HTML5 "required" validation attr
		}
        $out .= '<select name="'. $name. '" '. (isset($params['attrs']) ? $params['attrs'] : ''). '>';
        if(isset($params['options']) && !empty($params['options'])) {
            //$out .= '<option value=" ">Choose One</option>';	// Why this is here?

            foreach($params['options'] as $k => $v) {
                $selected = (isset($params['value']) && $k == $params['value'] ? 'selected="true"' : '');
                $out .= '<option value="'. $k. '" '. $selected. '>'. $v. '</option>';
            }
        }
        $out .= '</select>';
        return $out;
    }
    static public function selectlist($name, $params = array('attrs'=>'', 'size'=> 5, 'options' => array(), 'value' => '')) {
        $out = '';
        if(!strpos($name, '[]')) 
            $name .= '[]';
        if (!isset($params['size']) || !is_numeric($params['size']) || $params['size'] == '') {
            $params['size'] = 5;
        }
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['attrs'] .= self::_dataToAttrs($params);
        $out .= '<select multiple="multiple" size="'.$params['size'].'" name="'.$name.'" '.$params['attrs'].'>';
		$params['value'] = isset($params['value']) ? $params['value'] : array();
        if(isset($params['options']) && !empty($params['options'])) {
            foreach($params['options'] as $k => $v) {
                $selected = (in_array($k,(array)$params['value']) ? 'selected="true"' : '');
                $out .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
            }
        }
        $out .= '</select>';
        return $out; 
    }
	static public function file($name, $params = array()) {
		$params['type'] = 'file';
		return self::input($name, $params);
	}
    static public function ajaxfile($name, $params = array('url' => '', 'value' => '', 'fid' => '', 'buttonName' => '')) {

        $out = '';
		$params['value'] = isset($params['value']) ? $params['value'] : false;
		$butId = self::nameToClassId( $name );

        if($params['url'] == '') {
            $params['url'] = admin_url('admin-ajax.php');
        }

        $params['attrs'] = 'id="file-upload-input-' . $name . '" style="display: none;"';
        $out .= self::inputButton(array('value' => __( empty($params['buttonName'])
	        ? 'Upload'
	        :  $params['buttonName'] ), 'attrs' => 'id="'. $butId. '" class="ui button primary mini"')) .
	        '<div id="file-upload-wrapper" name="' . $name . '">' .
	        self::input($name, array('type' => 'hidden', 'attrs' => 'id="file-upload-' . $name . '"')) .
	        '</div>' .
            self::file('file-upload-' . $name, $params);
        $display = (empty($params['value']) ? 'display: none;' : '');

        $out .= '<div>' . self::img($params['value'], 0, array('attrs' => 'id="prev_'. $butId
                . '" style="height: 200px;' . $display . '" class="previewpicture"')) . '</div>';

        if(isset($params['addHidden']) && $params['addHidden']) {
			$out .= self::hidden($name, array('attrs' => 'id="'. $butId. '_hidden"'));
		}

		$out .= '<script type="text/javascript">// <!--
                jQuery("#'. $butId. '").click(function (e) {
                    jQuery(\'input[id="file-upload-input-' . $name . '"]\').click();
                });
                jQuery(\'input[id="file-upload-input-' . $name . '"]\').change(function () {
                    if (jQuery(this).val()) {
                        jQuery(".registration-submit").attr("disabled", "disabled");
                        Membership.api.base.uploadFile(
                            {image: jQuery(\'input[id="file-upload-input-' . $name . '"]\')[0].files[0]},
                            function (attachment) {
                                jQuery("#prev_'. $butId. '").attr("src", attachment.src).css("display", "block");
                                jQuery(".registration-submit").removeAttr("disabled");
                                jQuery(\'input[id="file-upload-' . $name . '"]:hidden\').val(attachment.id);
                            }
                        );
                    } else {
                        jQuery("#prev_'. $butId. '").attr("src", "").css("display", "none");
                    }
                });
            // --></script>';
        return $out;
    }
    static public function button($params = array('attrs' => '', 'value' => '')) {
        return '<button '. $params['attrs']. '>'. $params['value']. '</button>';
    }
	static public function buttonA($params = array('attrs' => '', 'value' => '')) {
		return '<a href="#" '. $params['attrs']. '>'. $params['value']. '</a>';
	}
    static public function inputButton($params = array('attrs' => '', 'value' => '')) {
		if(!is_array($params))
			$params = array();
		$params['type'] = 'button';
        return self::input('', $params);
    }
    static public function radiobuttons($name, $params = array('attrs' => '', 'options' => array(), 'value' => '', '')) {
		return self::_generateCheckList($name, $params, array('self', 'radiobutton'), array('self', '_checkEqual'));
    }
    static public function radiobutton($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
        $params['type'] = 'radio';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        if(isset($params['checked']) && $params['checked'])
            $params['attrs'] .= ' checked';
        return self::input($name, $params);
    }
    static public function nonajaxautocompleate($name, $params = array('attrs' => '', 'options' => array())) {
        if(empty($params['options'])) return false;
        $out = '';
        $jsArray = array();
        $oneItem = '<div id="%%ID%%"><div class="ac_list_item"><input type="hidden" name="'.$name.'[]" value="%%ID%%" />%%VAL%%</div><div class="close" onclick="removeAcOpt(%%ID%%)"></div><div class="br"></div></div>';
        $tID = $name. '_ac';
        $out .= self::text($tID. '_ac', array('attrs' => 'id="'.$tID.'"'));
        $out .= '<div id="'.$name.'_wraper">';
        foreach($params['options'] as $opt) {
            $jsArray[$opt['id']] = $opt['text'];
            if(isset($opt['checked']) && $opt['checked'] == 'checked') {
                $out .= str_replace(array('%%ID%%', '%%VAL%%'), array($opt['id'], $opt['text']), $oneItem);
            }
        }
        $out .= '</div>';
        $out .= '<script type="text/javascript">
                var ac_values_'.$name.' = '.json_encode(array_values($jsArray)).';
                var ac_keys_'.$name.' = '.json_encode(array_keys($jsArray)).';
                jQuery(document).ready(function(){
                    jQuery("#'.$tID.'").autocomplete(ac_values_'.$name.', {
                        autoFill: false,
                        mustMatch: false,
                        matchContains: false
                    }).result(function(a, b, c){
                        var keyID = jQuery.inArray(c, ac_values_'.$name.');
                        if(keyID != -1) {
                            addAcOpt(ac_keys_'.$name.'[keyID], c, "'.$name.'");
                        }
                    });
                });
        </script>';
        return $out;
    }
    static public function formStart($name, $params = array('action' => '', 'method' => 'GET', 'attrs' => '', 'hideMethodInside' => false)) {
        $params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $params['action'] = isset($params['action']) ? $params['action'] : '';
        $params['method'] = isset($params['method']) ? $params['method'] : 'GET';
        if(isset($params['hideMethodInside']) && $params['hideMethodInside']) {
            return '<form name="'. $name. '" action="'. $params['action']. '" method="'. $params['method']. '" '. $params['attrs']. '>'. 
                self::hidden('method', array('value' => $params['method']));
        } else {
            return '<form name="'. $name. '" action="'. $params['action']. '" method="'. $params['method']. '" '. $params['attrs']. '>';
        }
    }
    static public function formEnd() {
        return '</form>';
    }
    static public function slider($name, $params = array('value' => 0, 'min' => 0, 'max' => 0, 'step' => 1, 'slide' => '')) {
        $id = self::nameToClassId($name, $params);
        $paramsStr = '';
        if(!isset($params['slide']) || (empty($params['slide']) && $params['slide'] !== false)) { //Can be set to false to ignore function onSlide event binding
            $params['slide'] = 'toeSliderMove';
        }
        if(!empty($params)) {
            $paramsArr = array();
            foreach($params as $k => $v) {
				if(in_array($k, array('attrs')) || strpos($k, '-')) continue;
                $value = (is_numeric($v) || in_array($k, array('slide'))) ? $v : '"'. $v. '"';
                $paramsArr[] = $k. ': '. $value;
            }
            $paramsStr = implode(', ', $paramsArr);
        }
		
        $res = '<div id="toeSliderDisplay_'. $id. '">'. (empty($params['value']) ? '' : $params['value']). '</div>';
        $res .= '<div id="'. $id. '"></div>';
        $params['attrs'] = 'id="toeSliderInput_'. $id. '"';
        $res .= self::hidden($name, $params);
        $res .= '<script type="text/javascript"><!-- 
            jQuery(function(){ 
                jQuery("#'. $id. '").slider({'. $paramsStr. '}); 
            }); 
            --></script>';
        return $res;
    }
	static public function colorpicker($name, $params = array('value' => '')) {
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$nameToClass = self::nameToClassId($name);
		$textId = self::nameToClassId($name, $params);
		if(strpos($params['attrs'], 'id="') === false) {
			$textId .= '_'. mt_rand(9, 9999);
			$params['attrs'] .= 'id="'. $textId. '"';
		}
		//$pickerId = $textId. '_picker';
		$params['attrs'] .= ' data-default-color="'. $params['value']. '"';
		$out = self::text($name, $params);
		//$out .= '<div style="position: absolute; z-index: 1;" id="'. $pickerId. '"></div>';
		$out .= '<script type="text/javascript">//<!--
			jQuery(function(){
				if(jQuery("#'. $textId. '").wpColorPicker) {
					jQuery("#'. $textId. '").wpColorPicker({
						change: function(event, ui) {
							// Find change functiona for this element, if such exist - triger it
							if(window["wpColorPicker_'. $nameToClass. '_change"]) {
								window["wpColorPicker_'. $nameToClass. '_change"](event, ui);
							}
						}
					});
				} else {
					var $colorInput = jQuery("<input type=\'color\' name=\'"+ jQuery("#'. $textId. '").attr("name")+ "\' />");
					$colorInput.val( jQuery("#'. $textId. '").val() ).insertAfter( jQuery("#'. $textId. '") );
					jQuery("#'. $textId. '").remove();
				}
			});
			//--></script>';
		return $out;
	}
	static public function checkboxHiddenVal($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$checkId = self::nameToClassId($name, $params);
		if(strpos($params['attrs'], 'id="') === false) {
			$checkId .= '_check';
		}
		$hideId = self::nameToClassId($name, $params). '_text';
		$paramsCheck = $paramsHidden = $params;
		if(strpos($params['attrs'], 'id="') === false) {
			$paramsCheck['attrs'] .= ' id="'. $checkId. '"';
		}
		$paramsCheck['attrs'] .= ' data-hideid="'. $hideId. '"';
		$paramsHidden['attrs'] = ' id="'. $hideId. '"';
		$paramsCheck['value'] = isset($paramsCheck['value']) ? $paramsCheck['value'] : '';
		$paramsCheck['checked'] = $paramsCheck['value'] ? '1' : '0';
		$out = self::checkbox(self::nameToClassId($name), $paramsCheck);
		$out .= self::hidden($name, $paramsHidden);
		$out .= '<script type="text/javascript">//<!--
			jQuery(function(){
				jQuery("#'. $checkId. '").change(function(){
					jQuery("#'. $hideId. '").val( (jQuery(this).attr("checked") ? 1 : 0) );
				});
			});
			//--></script>';
		return $out;
	}
	static public function slideInput($name, $params = array('attrs' => '', 'checked' => false, 'id' => '')) {
		$params = !isset($params) || empty($params) ? array() : $params;
		if(!isset($params['id'])) {
			$params['id'] = self::nameToClassId($name, $params);
			if(strpos($params['attrs'], 'id="') === false) {
				$params['id'] .= '_'. mt_rand(1, 99999);
			}
		}
		$params['checked'] = isset($params['checked']) ? (int) $params['checked'] : 0;
		$params['attrs'] = isset($params['attrs']) && !empty($params['attrs']) ? $params['attrs'] : '';
		$params['attrs'] .= ' id="'. $params['id']. '"';
		
		return '<a class="toeSlideShellCfs" href="#"'. $params['attrs']. '>
			<span class="toeSlideButtCfs"></span>
			<span class="toeSlideOnCfs">'. __('ON'). '</span>
			<span class="toeSlideOffCfs">'. __('OFF'). '</span>
			<input type="hidden" name="'. $name. '" />
		</a>
		<script type="text/javascript">
		// <!--
			jQuery(function(){
				jQuery("#'. $params['id']. '").slideInput('. $params['checked']. ');
			});
		// -->
		</script>';
	}
	static public function galleryBtn($name, $params = array()) {
		$galleryType = isset($params['galleryType']) ? $params['galleryType'] : 'all';
		$buttonId = self::nameToClassId($name, $params);
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		if(strpos($params['attrs'], 'id="') === false) {
			$buttonId .= '_'. mt_rand(1, 99999);
			$params['attrs'] .= ' id="'. $buttonId. '"';
		}
		$inputId = $buttonId. '_input';
		$out = self::hidden($name, array('value' => $params['value'], 'attrs' => 'id="'. $inputId. '"'));
		$onChange = isset($params['onChange']) ? $params['onChange'] : '';
		$buttonParams = $params;
		$buttonParams['value'] = isset($params['btnVal']) ? $params['btnVal'] : sprintf(__('Select %s', CFS_LANG_CODE), strFirstUp($galleryType));
		$out .= self::buttonA($buttonParams);
		$out .= '<script type="text/javascript">
		// <!--
			jQuery(function(){
				// Run onChange to make pre-set of required data
				'. ($onChange ? $onChange. '("'. $params['value']. '", null, "'. $buttonId. '");' : ''). '
				jQuery("#'. $buttonId. '").click(function(){
					var button = jQuery(this);
					_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							jQuery("#'. $inputId. '").val( attachment.url ).trigger("change");
							'. ($onChange ? $onChange. '(attachment.url, attachment, "'. $buttonId. '");' : ''). '
						} else {
							return _orig_send_attachment.apply( this, [props, attachment] );
						};
					};
					wp.media.editor.open(button);
					jQuery(".attachment-filters").val("'. $galleryType. '").trigger("change");
					return false;
				});
			});
		// -->
		</script>';
		return $out;
	}
	static public function imgGalleryBtn($name, $params = array()) {
		$params['galleryType'] = 'image';
		return self::galleryBtn($name, $params);
	}
	static public function audioGalleryBtn($name, $params = array()) {
		$params['galleryType'] = 'audio';
		return self::galleryBtn($name, $params);
	}
	static public function checkedOpt($arr, $key, $value = true, $default = false) {
		if(!isset($arr[ $key ])) {
			return $default ? true : false;
		}
		return $value === true ? $arr[ $key ] : $arr[ $key ] == $value;
	}
	static public function recaptcha($name, $params = array()) {
        wp_enqueue_script('google.recaptcha', 'https://www.google.com/recaptcha/api.js');
		$res = '<div class="g-recaptcha" '
			. 'data-sitekey="'. $params['sitekey']. '" '
			. (isset($params['theme']) ? 'data-theme="'. $params['theme']. '" ' : '')
			. (isset($params['type']) ? 'data-type="'. $params['type']. '" ' : '')
			. (isset($params['size']) ? 'data-size="'. $params['size']. '" ' : '')
			. '></div>';
		return $res;
	}
	static public function wpEditor($name, $params = array()) {
		$params = $params ? $params : array();
		return wp_editor((isset($params['value']) ? $params['value'] : ''), 
			$name, array_merge(array(
				'drag_drop_upload' => true,
		), $params));
}
}

