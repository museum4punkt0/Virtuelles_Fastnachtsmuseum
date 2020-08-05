var BBSceneSettings = React.createClass({

    getInitialState: function() {

		var settings = this.props.settings;
		if(this.props.edit != '') {
			settings = jQuery.extend( true, this.props.settings, this.props.edit );
		}
        return {
			settings: settings,
		};
    },
    
    getChecked: function(val){
        return (val == 'on' || val == true) ? 1 : 0;
    },

    onChange: function(event) {
        var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        var name = target.name;

		var oldSettings = this.state.settings;
		var newSettings = {[name]: value};
		newSettings = jQuery.extend( true, oldSettings, newSettings );

        this.setState({settings: newSettings});
    },
	onChangeGeneral: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        if(target.type == 'checkbox') {
            value = (target.checked) ? 'on' : 'off';
        }
        var name = target.name;
        if(target.type == 'checkbox' && (name=='pushFollowers' || name=='reverse')) {
            value = (target.checked) ? true : false;
        }
		var oldSettings = this.state.settings;
		var newSettings = { general: {[name]: value} };
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},
	onChangeInit: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        var name = target.name;
		var oldSettings = this.state.settings;
		var newSettings = { init: {[name]: value} };
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},
	onChangeScroll: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        var name = target.name;
		var oldSettings = this.state.settings;
		var newSettings = { scroll: {[name]: value} };
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},
	onChangeEase: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        var name = target.name;
		var oldSettings = this.state.settings;
		var newSettings = { ease: {[name]: value} };
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},
	onChangeClass: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        if(target.type == 'checkbox') {
            value = (target.checked) ? 'on' : 'off';
        }
        var name = target.name;
		var oldSettings = this.state.settings;
		var newSettings = { class: {[name]: value} };
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},

	onChangeMisc: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        if(target.type == 'checkbox') {
            value = (target.checked) ? 'on' : 'off';
        }
        var name = target.name;
		var oldSettings = this.state.settings;
		var newSettings = { misc: {[name]: value} };
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},

	updateState: function(newSettings){
		var oldSettings = this.state.settings;
		newSettings = jQuery.extend( true, oldSettings, newSettings );
        this.setState({settings: newSettings});
	},

	addBezier: function(){
		var newSettings = this.state.settings.bezier.push({x: 0, y: 0});
		this.updateState(newSettings);
	},

	removeBezier: function(index){
		this.state.settings.bezier.splice(index, 1);
		this.updateState({bezier: this.state.settings.bezier});
	},

	upBezier: function(index){
		if(index == 0) {
			return;
		}

		var tmp = this.state.settings.bezier[index - 1];
		this.state.settings.bezier[index - 1] = this.state.settings.bezier[index];
		this.state.settings.bezier[index] = tmp;

		this.updateState({bezier: this.state.settings.bezier});
	},
	downBezier: function(index){
		if(index == this.state.settings.bezier.length - 1) {
			return;
		}
		var tmp = this.state.settings.bezier[index + 1];
		this.state.settings.bezier[index + 1] = this.state.settings.bezier[index];
		this.state.settings.bezier[index] = tmp;

		this.updateState({bezier: this.state.settings.bezier});
	},

	changeXBezier: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        var name = target.name;
		var index = target.getAttribute('data-index');
		this.state.settings.bezier[index].x = value;
        this.updateState({bezier: this.state.settings.bezier});
	},

	changeYBezier: function(event){
		var target = event.target;
        var value = target.type === 'checkbox'
            ? target.checked
            : target.value;
        var name = target.name;
		var index = target.getAttribute('data-index');
		this.state.settings.bezier[index].y = value;
        this.updateState({bezier: this.state.settings.bezier});
	},

	saveScene: function(){
		var thiss = this;
		jQuery('.bb-ajax-loading').css({display: 'flex'});

        if(this.state.settings.general.title == '') {
			jQuery('.bb-ajax-loading').css({display: 'none'});
			jQuery.growl( {title: "Warning", message: "Please enter Scene title", location :"br", style: 'warning' });
			return;
		}
        
        if(this.state.settings.general.name == '') {
			jQuery('.bb-ajax-loading').css({display: 'none'});
            jQuery.growl( {title: "Warning", message: "Please enter Name ID", location :"br", style: 'warning' });
			return;
		}

		jQuery.post(
		    ajaxurl,
		    {
		        'action': 'update_scene',
		        'data':   this.state.settings
		    },
		    function(response){
				response = JSON.parse(response);
				jQuery('.bb-ajax-loading').css({display: 'none'});
				if(typeof response.status != undefined && response.status == 'ok') {
                
                    window.history.pushState("edit", "Edit", "?page=bbsm-add-scene&idScene="+response.scene_id);
                
					thiss.updateState({ scene_id: response.scene_id });
                    thiss.updateState({ general: { name: response.name } });
                    jQuery.growl( {title: "Successful", message: response.msg, location :"br", style: 'notice' });
				} else {
					jQuery.growl( {title: "Fail", message: response.msg, location :"br", style: 'error' });
				}
		    }
		);
	},

    componentDidMount: function() {
		var thiss = this;
        (function($) {
            var $bb_tabs = $('.bb-tabs');
            if ($bb_tabs.length > 0) {
                $bb_tabs.find('.tab').on('click', function() {
                    var $tab_content = $($(this).data('target'));
                    $(this).addClass('active').siblings().removeClass('active');
                    if ($tab_content.length > 0) {
                        $tab_content.addClass('active').siblings().removeClass('active');
                    }
                });
            }
            
            var $bb_box_title = $('.bb-box-title');
            if ($bb_box_title.length > 0) {
                $bb_box_title.on('click', function() {
                    $('#' + $(this).attr('data-target')).toggleClass('bb-minimal');
                });
            }

			// Color picker
			$('.bb-field-color').wpColorPicker({
				change: function(event, ui){
					var element = event.target;
        			var color = ui.color.toString();

					// Fire trigger change in Reactjs
					setTimeout(function(){
						if($(element).hasClass('init')) {
							thiss.onChangeInit(event);
						} else {
							thiss.onChangeScroll(event);
						}
					}, 100);
				}
			});

        }(window.jQuery));

    },

    render: function() {
        return (
			<div className="bbvcvs-wrapper">
                <h2 className="bb-headtitle bbsm-headtitle">
                    <span>Scene</span>
                    <a id="bbvcvs-save-scene" className="bbvcvs-save-scene" href="javascript:;" onClick={this.saveScene}><span className="dashicons dashicons-admin-generic"></span> Save Changes</a>
                </h2>
	            <div className="bb-row">

	                <BBScenePreview settings={this.state.settings} text={this.props.text} />

                    <div className="bb-col-settings-container">
                    
    	                <div id="bb-vcvs-general-settings" className="bb-col-settings">
    	                    <h3 className="bb-box-title" data-target="bb-vcvs-general-settings">
    	                        <i className="dashicons dashicons-admin-generic"></i>
    	                        <span>{this.props.text.sceneSettings}</span> 
                                <span className="dashicons dashicons-arrow-down"></span>
    	                    </h3>
    	                    <div className="inside tabs-container">
    	                        <ul className="bb-tabs tabs">
    	                            <li className="active tab" data-target="#bb-vcvs-general">{this.props.text.general}</li>
    	                            <li className="tab" data-target="#bb-vcvs-classes">{this.props.text.classes}</li>
                                    <li className="tab" data-target="#bb-vcvs-bezier">{this.props.text.bezier}</li>
    	                            <li className="tab" data-target="#bb-vcvs-ease">{this.props.text.ease}</li>
    								<li className="tab" data-target="#bb-vcvs-misc">Misc</li>
    	                        </ul>

    	                        <div id="bb-vcvs-general" className="tab-content active">
                                    <span className="bb-label">Title</span>
    	                            <input type="text" className="bb-field" name="title" value={this.state.settings.general.title} onChange={this.onChangeGeneral} />
    	                            <div className="clear"></div>
                                    
                                    <span className="bb-label">Name ID (Class name)</span>
    	                            <input type="text" className="bb-field" name="name" value={this.state.settings.general.name} onChange={this.onChangeGeneral} />
    	                            <div className="clear"></div>
                                    
                                    <hr/>

    								<h4>Optional</h4>
                                    
                                    <span className="bb-label">Reverse</span>
                                    <label className="switch">
                                      <input name="reverse" onChange={this.onChangeGeneral} type="checkbox" checked={this.getChecked(this.state.settings.general.reverse)} />
                                      <span className="slider round"></span>
                                    </label>
                                    <div className="clear"></div>
                                    
                                    <span className="bb-label">Vertical</span>
                                    <label className="switch">
                                      <input name="vertical" onChange={this.onChangeGeneral} type="checkbox" checked={this.getChecked(this.state.settings.general.vertical)} />
                                      <span className="slider round"></span>
                                    </label>
    	                            <div className="clear"></div>
                                    
                                    <span className="bb-label">Point of execution</span>
    	                            <select className="bb-field" name="triggerElement" value={this.state.settings.general.triggerElement} onChange={this.onChangeGeneral} >
                                        <option value="">Default</option>
    	                                <option value="top-document">Top of Document</option>
                                    </select>
                                    <div className="clear"></div>

    								<span className="bb-label">TriggerHook</span>
    								<div className="range-slider">
    									<input className="range-slider__range" name="triggerHook" type="range" defaultValue={this.state.settings.general.triggerHook} min="0" max="1" step="0.01"  onChange={this.onChangeGeneral} />
    									<span className="range-slider__value">{this.state.settings.general.triggerHook}</span>
    								</div>
    	                            <div className="clear"></div>

    								<span className="bb-label">Duration</span>
    	                            <input type="text" step="1" className="bb-field" name="duration" value={this.state.settings.general.duration} onChange={this.onChangeGeneral} />
    								<span>px</span>
    	                            <div className="clear"></div>

                                    <span className="bb-label">Offset</span>
    	                            <input type="text" step="1" className="bb-field" name="offset" value={this.state.settings.general.offset} onChange={this.onChangeGeneral} />
    								<span>px</span>
    	                            <div className="clear"></div>
                                    <hr/>
                                    
                                    <h4>Sticky</h4>
                                    
                                    <span className="bb-label">Pin</span>
                                    <label className="switch">
                                      <input name="pin" onChange={this.onChangeGeneral} type="checkbox" checked={this.getChecked(this.state.settings.general.pin)} />
                                      <span className="slider round"></span>
                                    </label>
                                    <div className="clear"></div>
                                    
                                    <span className="bb-label">PushFollowers</span>
                                    <label className="switch">
                                      <input name="pushFollowers" onChange={this.onChangeGeneral} type="checkbox" checked={this.getChecked(this.state.settings.general.pushFollowers)} />
                                      <span className="slider round"></span>
                                    </label>
                                    <div className="clear"></div>
    	                        </div>

    	                        <div id="bb-vcvs-ease" className="tab-content">

    								<span className="bb-label">Duration ease</span>
    								<input type="number" step="0.01" className="bb-field" name="duration" value={this.state.settings.ease.duration} onChange={this.onChangeEase} />
    	                            <span>s</span>
    	                            <div className="clear"></div>

    								<span className="bb-label">Delay</span>
    								<input type="number" step="0.01" className="bb-field" name="delay" value={this.state.settings.scroll.delay} onChange={this.onChangeScroll} />
    	                            <span>s</span>
    	                            <div className="clear"></div>

    								<span className="bb-label">Type</span>
    	                            <select className="bb-field" name="ease" value={this.state.settings.scroll.ease} onChange={this.onChangeScroll} >
    	                                <option value="Power0.easeNone">Power0.easeNone</option>

    									<option value="Power1.easeIn">Power1.easeIn</option>
    									<option value="Power1.easeInOut">Power1.easeInOut</option>
    									<option value="Power1.easeOut">Power1.easeOut</option>

    									<option value="Power2.easeIn">Power2.easeIn</option>
    									<option value="Power2.easeInOut">Power2.easeInOut</option>
    									<option value="Power2.easeOut">Power2.easeOut</option>

    									<option value="Power3.easeIn">Power3.easeIn</option>
    									<option value="Power3.easeInOut">Power3.easeInOut</option>
    									<option value="Power3.easeOut">Power3.easeOut</option>

    									<option value="Power4.easeIn">Power4.easeIn</option>
    									<option value="Power4.easeInOut">Power4.easeInOut</option>
    									<option value="Power4.easeOut">Power4.easeOut</option>

    									<option value="Back.easeIn.config(1.7)">Back.easeIn</option>
    									<option value="Back.easeInOut.config(1.7)">Back.easeInOut</option>
    									<option value="Back.easeOut.config(1.7)">Back.easeOut</option>

    									<option value="Elastic.easeIn.config(1, 0.3)">Elastic.easeIn</option>
    									<option value="Elastic.easeInOut.config(1, 0.3)">Elastic.easeInOut</option>
    									<option value="Elastic.easeOut.config(1, 0.3)">Elastic.easeOut</option>

    									<option value="Bounce.easeIn">Bounce.easeIn</option>
    									<option value="Bounce.easeInOut">Bounce.easeInOut</option>
    									<option value="Bounce.easeOut">Bounce.easeOut</option>

    									<option value="SlowMo.ease.config(0.7, 0.7, false)">SlowMo</option>
    									<option value="SteppedEase.config(12)">Stepped</option>

    									<option value="Circ.easeIn">Circ.easeIn</option>
    									<option value="Circ.easeInOut">Circ.easeInOut</option>
    									<option value="Circ.easeOut">Circ.easeOut</option>

    									<option value="Expo.easeIn">Expo.easeIn</option>
    									<option value="Expo.easeInOut">Expo.easeInOut</option>
    									<option value="Expo.easeOut">Expo.easeOut</option>

    									<option value="Sine.easeIn">Sine.easeIn</option>
    									<option value="Sine.easeInOut">Sine.easeInOut</option>
    									<option value="Sine.easeOut">Sine.easeOut</option>

    	                            </select>
    	                            <div className="clear"></div>
    	                        </div>
    							<div id="bb-vcvs-bezier" className="tab-content bb-two-label">
    								{this.state.settings.bezier.map((item, index) => {
    									return (
    										<div>
    											<span onClick={() => this.upBezier(index)} className="btn-up-bezier dashicons dashicons-arrow-up-alt"></span>
    											<span onClick={() => this.downBezier(index)} className="btn-down-bezier dashicons dashicons-arrow-down-alt"></span>

    											<span className="bb-label">x :</span>
    			  	                            <input type="number" step="1" className="bb-field" name="x" value={item.x} data-index={index} onChange={this.changeXBezier} />
    											<span className="bb-label">y :</span>
    											<input type="number" step="1" className="bb-field" name="y" value={item.y} data-index={index} onChange={this.changeYBezier} />

    											<span onClick={() => this.removeBezier(index)} className="btn-remove-bezier dashicons dashicons-trash"></span>
    			  	                            <div className="clear"></div>
    										</div>
    									)
    							  	})}
    								<span onClick={this.addBezier} className="btn-add-bezier dashicons dashicons-plus"></span>
    							</div>
    	                        <div id="bb-vcvs-classes" className="tab-content">
                                    <span className="bb-label">Enable</span>
                                    <label className="switch">
                                      <input name="classToggleEnable" onChange={this.onChangeClass} type="checkbox" checked={this.getChecked(this.state.settings.class.classToggleEnable)} />
                                      <span className="slider round"></span>
                                    </label>
                                    <div className="clear"></div>

    								<span className="bb-label">Class CSS</span>
    	                            <select className="bb-field" name="classCSS" value={this.state.settings.class.classCSS} onChange={this.onChangeClass} >
    									<optgroup label="Attention Seekers">
    										<option value="bounce">bounce</option>
    										<option value="flash">flash</option>
    										<option value="pulse">pulse</option>
    										<option value="rubberBand">rubberBand</option>
    										<option value="shake">shake</option>
    										<option value="swing">swing</option>
    										<option value="tada">tada</option>
    										<option value="wobble">wobble</option>
    										<option value="jello">jello</option>
    									</optgroup>
    									<optgroup label="Bouncing Entrances">
    										<option value="bounceIn">bounceIn</option>
    										<option value="bounceInDown">bounceInDown</option>
    										<option value="bounceInLeft">bounceInLeft</option>
    										<option value="bounceInRight">bounceInRight</option>
    										<option value="bounceInUp">bounceInUp</option>
    									</optgroup>
    									<optgroup label="Bouncing Exits">
    										<option value="bounceOut">bounceOut</option>
    										<option value="bounceOutDown">bounceOutDown</option>
    										<option value="bounceOutLeft">bounceOutLeft</option>
    										<option value="bounceOutRight">bounceOutRight</option>
    										<option value="bounceOutUp">bounceOutUp</option>
    									</optgroup>
    									<optgroup label="Fading Entrances">
    										<option value="fadeIn">fadeIn</option>
    										<option value="fadeInDown">fadeInDown</option>
    										<option value="fadeInDownBig">fadeInDownBig</option>
    										<option value="fadeInLeft">fadeInLeft</option>
    										<option value="fadeInLeftBig">fadeInLeftBig</option>
    										<option value="fadeInRight">fadeInRight</option>
    										<option value="fadeInRightBig">fadeInRightBig</option>
    										<option value="fadeInUp">fadeInUp</option>
    										<option value="fadeInUpBig">fadeInUpBig</option>
    									</optgroup>
    									<optgroup label="Fading Exits">
    										<option value="fadeOut">fadeOut</option>
    										<option value="fadeOutDown">fadeOutDown</option>
    										<option value="fadeOutDownBig">fadeOutDownBig</option>
    										<option value="fadeOutLeft">fadeOutLeft</option>
    										<option value="fadeOutLeftBig">fadeOutLeftBig</option>
    										<option value="fadeOutRight">fadeOutRight</option>
    										<option value="fadeOutRightBig">fadeOutRightBig</option>
    										<option value="fadeOutUp">fadeOutUp</option>
    										<option value="fadeOutUpBig">fadeOutUpBig</option>
    									</optgroup>
    									<optgroup label="Flippers">
    										<option value="flip">flip</option>
    										<option value="flipInX">flipInX</option>
    										<option value="flipInY">flipInY</option>
    										<option value="flipOutX">flipOutX</option>
    										<option value="flipOutY">flipOutY</option>
    									</optgroup>
    									<optgroup label="Lightspeed">
    										<option value="lightSpeedIn">lightSpeedIn</option>
    										<option value="lightSpeedOut">lightSpeedOut</option>
    									</optgroup>
    									<optgroup label="Rotating Entrances">
    										<option value="rotateIn">rotateIn</option>
    										<option value="rotateInDownLeft">rotateInDownLeft</option>
    										<option value="rotateInDownRight">rotateInDownRight</option>
    										<option value="rotateInUpLeft">rotateInUpLeft</option>
    										<option value="rotateInUpRight">rotateInUpRight</option>
    									</optgroup>
    									<optgroup label="Rotating Exits">
    										<option value="rotateOut">rotateOut</option>
    										<option value="rotateOutDownLeft">rotateOutDownLeft</option>
    										<option value="rotateOutDownRight">rotateOutDownRight</option>
    										<option value="rotateOutUpLeft">rotateOutUpLeft</option>
    										<option value="rotateOutUpRight">rotateOutUpRight</option>
    									</optgroup>
    									<optgroup label="Sliding Entrances">
    										<option value="slideInUp">slideInUp</option>
    										<option value="slideInDown">slideInDown</option>
    										<option value="slideInLeft">slideInLeft</option>
    										<option value="slideInRight">slideInRight</option>
    									</optgroup>
    									<optgroup label="Sliding Exits">
    										<option value="slideOutUp">slideOutUp</option>
    										<option value="slideOutDown">slideOutDown</option>
    										<option value="slideOutLeft">slideOutLeft</option>
    										<option value="slideOutRight">slideOutRight</option>
    									</optgroup>
    									<optgroup label="Zoom Entrances">
    										<option value="zoomIn">zoomIn</option>
    										<option value="zoomInDown">zoomInDown</option>
    										<option value="zoomInLeft">zoomInLeft</option>
    										<option value="zoomInRight">zoomInRight</option>
    										<option value="zoomInUp">zoomInUp</option>
    									</optgroup>
    									<optgroup label="Zoom Exits">
    										<option value="zoomOut">zoomOut</option>
    										<option value="zoomOutDown">zoomOutDown</option>
    										<option value="zoomOutLeft">zoomOutLeft</option>
    										<option value="zoomOutRight">zoomOutRight</option>
    										<option value="zoomOutUp">zoomOutUp</option>
    									</optgroup>
    									<optgroup label="Specials">
    										<option value="hinge">hinge</option>
    										<option value="rollIn">rollIn</option>
    										<option value="rollOut">rollOut</option>
    									</optgroup>
    	                            </select>
    	                            <div className="clear"></div>
    	                        </div>

    							<div id="bb-vcvs-misc" className="tab-content">
                                    <span className="bb-label">Draw SVG</span>
                                    <label className="switch">
                                      <input name="drawSVG" onChange={this.onChangeMisc} type="checkbox" checked={this.getChecked(this.state.settings.misc.drawSVG)} />
                                      <span className="slider round"></span>
                                    </label>
    	                            <div className="clear"></div>
                                    
                                    <span className="bb-label">Selector</span>
                                    <label className="bb-field">
                                      <input type="text" className="bb-field" name="selector" value={this.state.settings.misc.selector} onChange={this.onChangeMisc} />
                                    </label>
    	                            <div className="clear"></div>
                                    
                                    <span className="bb-label">Container</span>
                                    <label className="bb-field">
                                      <input type="text" className="bb-field" name="container" value={this.state.settings.misc.container} onChange={this.onChangeMisc} />
                                    </label>
    	                            <div className="clear"></div>
                                    
    							</div>

    	                    </div>
    	                </div>
                        
                        <div id="bb-vcvs-bs-settings" className="bb-col-settings">
    	                    <h3 className="bb-box-title" data-target="bb-vcvs-bs-settings">
    	                        <i className="dashicons dashicons-admin-generic"></i>
    	                        <span>Before scrolling</span>
                                <span className="dashicons dashicons-arrow-down"></span>
    	                    </h3>
    	                    <div className="inside tabs-container">
    	                        <ul className="bb-tabs tabs">
    								<li className="active tab" data-target="#bb-vcvs-transform">Transform</li>
    	                            <li className="tab" data-target="#bb-vcvs-color">Color</li>
    	                            <li className="tab" data-target="#bb-vcvs-position">Position</li>
    								<li className="tab" data-target="#bb-vcvs-bsmisc">Misc</li>
    	                        </ul>

    							<div id="bb-vcvs-transform" className="tab-content active">
    								<h4>Transform</h4>
    								<span className="bb-label">TranslateX</span>
    								<input type="text" step="1" className="bb-field" name="x" value={this.state.settings.init.x} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>

    								<span className="bb-label">TranslateY</span>
    								<input type="text" step="1" className="bb-field" name="y" value={this.state.settings.init.y} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>

    								<span className="bb-label">TranslateZ</span>
    								<input type="text" step="0.1" className="bb-field" name="z" value={this.state.settings.init.z} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>

    								<span className="bb-label">ScaleX</span>
    								<input type="number" step="0.5" className="bb-field" name="scaleX" value={this.state.settings.init.scaleX} onChange={this.onChangeInit} />
    								<div className="clear"></div>

    								<span className="bb-label">ScaleY</span>
    								<input type="number" step="0.5" className="bb-field" name="scaleY" value={this.state.settings.init.scaleY} onChange={this.onChangeInit} />
    								<div className="clear"></div>

    								<span className="bb-label">ScaleZ</span>
    								<input type="number" step="0.5" className="bb-field" name="scaleZ" value={this.state.settings.init.scaleZ} onChange={this.onChangeInit} />
    								<div className="clear"></div>

    								<span className="bb-label">Rotate</span>
    								<input type="number" step="1" className="bb-field" name="rotation" value={this.state.settings.init.rotation} onChange={this.onChangeInit} />
    								<span>deg</span>
    								<div className="clear"></div>

    								<span className="bb-label">RotateX</span>
    								<input type="number" step="1" className="bb-field" name="rotationX" value={this.state.settings.init.rotationX} onChange={this.onChangeInit} />
    								<span>deg</span>
    								<div className="clear"></div>

    								<span className="bb-label">RotateY</span>
    								<input type="number" step="1" className="bb-field" name="rotationY" value={this.state.settings.init.rotationY} onChange={this.onChangeInit} />
    								<span>deg</span>
    								<div className="clear"></div>

    								<span className="bb-label">RotateZ</span>
    								<input type="number" step="1" className="bb-field" name="rotationZ" value={this.state.settings.init.rotationZ} onChange={this.onChangeInit} />
    								<span>deg</span>
    								<div className="clear"></div>

    								<span className="bb-label">SkewX</span>
    								<input type="number" step="1" className="bb-field" name="skewX" value={this.state.settings.init.skewX} onChange={this.onChangeInit} />
    								<span>deg</span>
    								<div className="clear"></div>

    								<span className="bb-label">SkewY</span>
    								<input type="number" step="1" className="bb-field" name="skewY" value={this.state.settings.init.skewY} onChange={this.onChangeInit} />
    								<span>deg</span>
    								<div className="clear"></div>
                                    
    							</div>
                                
                                <div id="bb-vcvs-color" className="tab-content">
    								<h4>Color</h4>
    								<span className="bb-label">Color</span>
    								<input type="text" className="bb-field bb-field-color init" name="color" value={this.state.settings.init.color} onChange={this.onChangeInit} />
    								<div className="clear"></div>
                                    
                                    <h4>Background</h4>
    								<span className="bb-label">Background Color</span>
    								<input type="text" className="bb-field bb-field-color init" name="backgroundColor" value={this.state.settings.init.backgroundColor} onChange={this.onChangeInit} />
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Background Attachment</span>
                                    <select className="bb-field" name="backgroundAttachment" value={this.state.settings.init.backgroundAttachment} onChange={this.onChangeInit} >
    										<option value="">Default</option>
                                            <option value="scroll">Scroll</option>
                                            <option value="fixed">Fixed</option>
                                            <option value="local">Local</option>
                                            <option value="initial">Initial</option>
                                            <option value="inherit">Inherit</option>
                                    </select>
                                    <div className="clear"></div>
                                </div>
                                
                                <div id="bb-vcvs-position" className="tab-content">
                                    <h4>Position</h4>
                                    
                                    <span className="bb-label">Position</span>
                                    <select className="bb-field" name="position" value={this.state.settings.init.position} onChange={this.onChangeInit} >
    										<option value="">Default</option>
                                            <option value="relative">Relative</option>
                                            <option value="absolute">Absolute</option>
                                            <option value="fixed">Fixed</option>
                                    </select>
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Top</span>
    								<input type="text" step="1" className="bb-field" name="top" value={this.state.settings.init.top} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Left</span>
    								<input type="text" step="1" className="bb-field" name="left" value={this.state.settings.init.left} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Bottom</span>
    								<input type="text" step="1" className="bb-field" name="bottom" value={this.state.settings.init.bottom} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Right</span>
    								<input type="text" step="1" className="bb-field" name="right" value={this.state.settings.init.right} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>
                                </div>
                                
                                <div id="bb-vcvs-bsmisc" className="tab-content">
    								<h4>Other</h4>
                                    
                                    <span className="bb-label">Width</span>
    								<input type="text" step="1" className="bb-field" name="width" value={this.state.settings.init.width} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Height</span>
    								<input type="text" step="1" className="bb-field" name="height" value={this.state.settings.init.height} onChange={this.onChangeInit} />
    								<span>px</span>
    								<div className="clear"></div>
                                    
    								<span className="bb-label">Opacity</span>    
                                    <div className="range-slider">
    									<input className="range-slider__range" name="opacity" type="range" defaultValue={this.state.settings.init.opacity} min="0" max="1" step="0.01"  onChange={this.onChangeInit} />
    									<span className="range-slider__value">{this.state.settings.init.opacity}</span>
    								</div>
                                    <div className="clear"></div>
                                    
                                    <span className="bb-label">Z-Index</span>
    								<input type="number" step="1" className="bb-field" name="zIndex" value={this.state.settings.init.zIndex} onChange={this.onChangeInit} />
    								<div className="clear"></div>
                                    
                                    <span className="bb-label">Overflow</span>
                                    <select className="bb-field" name="overflow" value={this.state.settings.init.overflow} onChange={this.onChangeInit} >
    										<option value="">Default</option>
                                            <option value="collapse">Collapse</option>
                                            <option value="hidden">Hidden</option>
                                            <option value="inherit">Inherit</option>
                                            <option value="initial">Initial</option>
                                            <option value="unset">Unset</option>
                                            <option value="visible">Visible</option>
                                    </select>
    								<div className="clear"></div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div id="bb-vcvs-as-settings" className="bb-col-settings">
    	                    <h3 className="bb-box-title" data-target="bb-vcvs-as-settings">
    	                        <i className="dashicons dashicons-admin-generic"></i>
    	                        <span>After scrolling</span>
                                <span className="dashicons dashicons-arrow-down"></span>
    	                    </h3>
    	                    <div className="inside tabs-container">
    	                        <ul className="bb-tabs tabs">
    								<li className="active tab" data-target="#bb-vcvsac-transform">Transform</li>
    	                            <li className="tab" data-target="#bb-vcvsac-color">Color</li>
    	                            <li className="tab" data-target="#bb-vcvsac-position">Position</li>
    								<li className="tab" data-target="#bb-vcvsac-asmisc">Misc</li>
    	                        </ul>
                                
                                <div id="bb-vcvsac-transform" className="tab-content active">

        							<h4>Transform</h4>
        							<span className="bb-label">TranslateX</span>
                                    <input type="text" step="1" className="bb-field" name="x" value={this.state.settings.scroll.x} onChange={this.onChangeScroll} />
        							<span>px</span>
                                    <div className="clear"></div>

        							<span className="bb-label">TranslateY</span>
                                    <input type="text" step="1" className="bb-field" name="y" value={this.state.settings.scroll.y} onChange={this.onChangeScroll} />
        							<span>px</span>
                                    <div className="clear"></div>

        							<span className="bb-label">TranslateZ</span>
                                    <input type="text" step="0.1" className="bb-field" name="z" value={this.state.settings.scroll.z} onChange={this.onChangeScroll} />
        							<span>px</span>
                                    <div className="clear"></div>

        							<span className="bb-label">ScaleX</span>
                                    <input type="number" step="0.5" className="bb-field" name="scaleX" value={this.state.settings.scroll.scaleX} onChange={this.onChangeScroll} />
                                    <div className="clear"></div>

        							<span className="bb-label">ScaleY</span>
                                    <input type="number" step="0.5" className="bb-field" name="scaleY" value={this.state.settings.scroll.scaleY} onChange={this.onChangeScroll} />
                                    <div className="clear"></div>

        							<span className="bb-label">ScaleZ</span>
                                    <input type="number" step="0.5" className="bb-field" name="scaleZ" value={this.state.settings.scroll.scaleZ} onChange={this.onChangeScroll} />
                                    <div className="clear"></div>

        							<span className="bb-label">Rotate</span>
                                    <input type="number" step="1" className="bb-field" name="rotation" value={this.state.settings.scroll.rotation} onChange={this.onChangeScroll} />
        							<span>deg</span>
                                    <div className="clear"></div>

        							<span className="bb-label">RotateX</span>
                                    <input type="number" step="1" className="bb-field" name="rotationX" value={this.state.settings.scroll.rotationX} onChange={this.onChangeScroll} />
        							<span>deg</span>
                                    <div className="clear"></div>

        							<span className="bb-label">RotateY</span>
                                    <input type="number" step="1" className="bb-field" name="rotationY" value={this.state.settings.scroll.rotationY} onChange={this.onChangeScroll} />
        							<span>deg</span>
                                    <div className="clear"></div>

        							<span className="bb-label">RotateZ</span>
                                    <input type="number" step="1" className="bb-field" name="rotationZ" value={this.state.settings.scroll.rotationZ} onChange={this.onChangeScroll} />
        							<span>deg</span>
                                    <div className="clear"></div>

        							<span className="bb-label">SkewX</span>
                                    <input type="number" step="1" className="bb-field" name="skewX" value={this.state.settings.scroll.skewX} onChange={this.onChangeScroll} />
        							<span>deg</span>
                                    <div className="clear"></div>

        							<span className="bb-label">SkewY</span>
                                    <input type="number" step="1" className="bb-field" name="skewY" value={this.state.settings.scroll.skewY} onChange={this.onChangeScroll} />
        							<span>deg</span>
                                    <div className="clear"></div>
                                    
                                </div>
                                
                                <div id="bb-vcvsac-color" className="tab-content">
        							<h4>Color</h4>
        							<span className="bb-label">Color</span>
        							<input type="text" className="bb-field bb-field-color" name="color" value={this.state.settings.scroll.color} onChange={this.onChangeScroll} />
                                    <div className="clear"></div>

                                    <h4>Background</h4>
                                    
        							<span className="bb-label">Background Color</span>
                                    <input type="text" className="bb-field bb-field-color" name="backgroundColor" value={this.state.settings.scroll.backgroundColor} onChange={this.onChangeScroll} />
                                    <div className="clear"></div>
                                    
                                    <span className="bb-label">Background Attachment</span>
                                    <select className="bb-field" name="backgroundAttachment" value={this.state.settings.scroll.backgroundAttachment} onChange={this.onChangeScroll} >
                                        <option value="">Default</option>
                                        <option value="-webkit-paged-x">-webkit-paged-x</option>
                                        <option value="-webkit-paged-y">-webkit-paged-y</option>
                                        <option value="auto">auto</option>
                                        <option value="hidden">hidden</option>
                                        <option value="inherit">inherit</option>
                                        <option value="initial">initial</option>
                                        <option value="overlay">overlay</option>
                                        <option value="scroll">scroll</option>
                                        <option value="unset">unset</option>
                                        <option value="visible">visible</option>
                                    </select>
                                    <div className="clear"></div>
                                </div>
                                
                                <div id="bb-vcvsac-position" className="tab-content">
                                    <h4>Position</h4>
                                    
                                    <span className="bb-label">Position</span>
                                    <select className="bb-field" name="position" value={this.state.settings.scroll.position} onChange={this.onChangeScroll} >
        									<option value="">Default</option>
                                            <option value="relative">Relative</option>
                                            <option value="absolute">Absolute</option>
                                            <option value="fixed">Fixed</option>
                                    </select>
        							<div className="clear"></div>
                                    
                                    <span className="bb-label">Top</span>
        							<input type="text" step="1" className="bb-field" name="top" value={this.state.settings.scroll.top} onChange={this.onChangeScroll} />
        							<span>px</span>
        							<div className="clear"></div>
                                    
                                    <span className="bb-label">Left</span>
        							<input type="text" step="1" className="bb-field" name="left" value={this.state.settings.scroll.left} onChange={this.onChangeScroll} />
        							<span>px</span>
        							<div className="clear"></div>
                                    
                                    <span className="bb-label">Bottom</span>
        							<input type="text" step="1" className="bb-field" name="bottom" value={this.state.settings.scroll.bottom} onChange={this.onChangeScroll} />
        							<span>px</span>
        							<div className="clear"></div>
                                    
                                    <span className="bb-label">Right</span>
        							<input type="text" step="1" className="bb-field" name="right" value={this.state.settings.scroll.right} onChange={this.onChangeScroll} />
        							<span>px</span>
        							<div className="clear"></div>
                                </div>
                                
                                <div id="bb-vcvsac-asmisc" className="tab-content">
                                    <h4>Other</h4>
                                    
                                    <span className="bb-label">Width</span>
        							<input type="text" step="1" className="bb-field" name="width" value={this.state.settings.scroll.width} onChange={this.onChangeScroll} />
        							<span>px</span>
        							<div className="clear"></div>
                                    
                                    <span className="bb-label">Height</span>
        							<input type="text" step="1" className="bb-field" name="height" value={this.state.settings.scroll.height} onChange={this.onChangeScroll} />
        							<span>px</span>
        							<div className="clear"></div>
                                    
        							<span className="bb-label">Opacity</span>
                                    <div className="range-slider">
        								<input className="range-slider__range" name="opacity" type="range" defaultValue={this.state.settings.scroll.opacity} min="0" max="1" step="0.01"  onChange={this.onChangeScroll} />
        								<span className="range-slider__value">{this.state.settings.scroll.opacity}</span>
        							</div>
                                    <div className="clear"></div>
                                    
                                    <span className="bb-label">Z-Index</span>
        							<input type="number" step="1" className="bb-field" name="zIndex" value={this.state.settings.scroll.zIndex} onChange={this.onChangeScroll} />
        							<div className="clear"></div>
                                    
                                    <span className="bb-label">Overflow</span>
                                    <select className="bb-field" name="overflow" value={this.state.settings.scroll.overflow} onChange={this.onChangeScroll} >
        									<option value="">Default</option>
                                            <option value="-webkit-paged-x">-webkit-paged-x</option>
                                            <option value="-webkit-paged-y">-webkit-paged-y</option>
                                            <option value="auto">auto</option>
                                            <option value="hidden">hidden</option>
                                            <option value="inherit">inherit</option>
                                            <option value="initial">initial</option>
                                            <option value="overlay">overlay</option>
                                            <option value="scroll">scroll</option>
                                            <option value="unset">unset</option>
                                            <option value="visible">visible</option>
                                    </select>
        							<div className="clear"></div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    
	            </div>
			</div>
        )
    }
});

var BBScenePreview = React.createClass({

    componentDidUpdate: function() {
		window.controller.destroy(true);
		window.controller = null;
		window.scene.destroy(true);
		this.bbScrollMagic();
		this.initStyle();
    },

    componentDidMount: function() {
		this.bbScrollMagic();
		this.initStyle();

		// Zoom Preview
		(function($) {
            var $previewExpand = $('#bb-vcvs-preview-expand');
			var $previewBox = $('#bb-vcvs-preview-container');

            if ($previewExpand.length > 0) {
                $previewExpand.on('click', function() {
					if($previewExpand.hasClass('active')) {
						$previewExpand.removeClass('active dashicons-no').addClass('dashicons-editor-expand');
						$previewBox.removeClass('active');
					} else {
						$previewExpand.addClass('active dashicons-no').removeClass('dashicons-editor-expand');
						$previewBox.addClass('active');
					}
                });
            }
        }(window.jQuery));

    },

	bbScrollMagic: function(){

		var tweenSettings = {}, duration = 0, delay = 0, durationEase = 0, durationString = '0', reverse = true, offset = 0, triggerHook = 0.5, vertical = this.props.settings.general.vertical, triggerElement = '';
        
        if(typeof this.props.settings.scroll.width != undefined && this.props.settings.scroll.width != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {width: this.props.settings.scroll.width} );
		}
        if(typeof this.props.settings.scroll.height != undefined && this.props.settings.scroll.height != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {height: this.props.settings.scroll.height} );
		}
        if(typeof this.props.settings.scroll.zIndex != undefined && this.props.settings.scroll.zIndex != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {zIndex: this.props.settings.scroll.zIndex} );
		}
        if(typeof this.props.settings.scroll.overflow != undefined && this.props.settings.scroll.overflow != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {overflow: this.props.settings.scroll.overflow} );
		}
        
        if(typeof this.props.settings.scroll.position != undefined && this.props.settings.scroll.position != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {position: this.props.settings.scroll.position} );
		}
        if(typeof this.props.settings.scroll.top != undefined && this.props.settings.scroll.top != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {top: this.props.settings.scroll.top} );
		}
        if(typeof this.props.settings.scroll.left != undefined && this.props.settings.scroll.left != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {left: this.props.settings.scroll.left} );
		}
        if(typeof this.props.settings.scroll.bottom != undefined && this.props.settings.scroll.bottom != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {bottom: this.props.settings.scroll.bottom} );
		}
        if(typeof this.props.settings.scroll.right != undefined && this.props.settings.scroll.right != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {right: this.props.settings.scroll.right} );
		}

		if(typeof this.props.settings.scroll.x != undefined && this.props.settings.scroll.x != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {x: this.props.settings.scroll.x} );
		}
		if(typeof this.props.settings.scroll.y != undefined && this.props.settings.scroll.y != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {y: this.props.settings.scroll.y} );
		}
		if(typeof this.props.settings.scroll.z != undefined && this.props.settings.scroll.z != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {z: this.props.settings.scroll.z} );
		}

		if(typeof this.props.settings.scroll.scaleX != undefined && this.props.settings.scroll.scaleX != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {scaleX: this.props.settings.scroll.scaleX} );
		}
		if(typeof this.props.settings.scroll.scaleY != undefined && this.props.settings.scroll.scaleY != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {scaleY: this.props.settings.scroll.scaleY} );
		}
		if(typeof this.props.settings.scroll.scaleZ != undefined && this.props.settings.scroll.scaleZ != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {scaleZ: this.props.settings.scroll.scaleZ} );
		}

		if(typeof this.props.settings.scroll.rotation != undefined && this.props.settings.scroll.rotation != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotation: this.props.settings.scroll.rotation} );
		}
		if(typeof this.props.settings.scroll.rotationX != undefined && this.props.settings.scroll.rotationX != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotationX: this.props.settings.scroll.rotationX} );
		}
		if(typeof this.props.settings.scroll.rotationY != undefined && this.props.settings.scroll.rotationY != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotationY: this.props.settings.scroll.rotationY} );
		}
		if(typeof this.props.settings.scroll.rotationZ != undefined && this.props.settings.scroll.rotationZ != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotationZ: this.props.settings.scroll.rotationZ} );
		}

		if(typeof this.props.settings.scroll.skewX != undefined && this.props.settings.scroll.skewX != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {skewX: this.props.settings.scroll.skewX} );
		}
		if(typeof this.props.settings.scroll.skewY != undefined && this.props.settings.scroll.skewY != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {skewY: this.props.settings.scroll.skewY} );
		}

		if(typeof this.props.settings.scroll.backgroundColor != undefined && this.props.settings.scroll.backgroundColor != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {backgroundColor: this.props.settings.scroll.backgroundColor} );
		}
		if(typeof this.props.settings.scroll.color != undefined && this.props.settings.scroll.color != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {color: this.props.settings.scroll.color} );
		}
		if(typeof this.props.settings.scroll.opacity != undefined && this.props.settings.scroll.opacity != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {opacity: this.props.settings.scroll.opacity} );
		}

		if(typeof this.props.settings.scroll.delay != undefined && this.props.settings.scroll.delay != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {delay: this.props.settings.scroll.delay} );
		}
		if(typeof this.props.settings.scroll.ease != undefined && this.props.settings.scroll.ease != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {ease: eval(this.props.settings.scroll.ease)} );
		}

		if(typeof this.props.settings.general.duration != undefined && this.props.settings.general.duration != '') {
			duration = this.props.settings.general.duration;
			durationString = "(duration: " + duration + ")";
		}
		if(typeof this.props.settings.general.offset != undefined && this.props.settings.general.offset != '') {
			offset = this.props.settings.general.offset;
		}
        if(typeof this.props.settings.general.triggerHook != undefined && this.props.settings.general.triggerHook != '') {
			triggerHook = this.props.settings.general.triggerHook;
		}
        if(typeof this.props.settings.general.reverse != undefined && this.props.settings.general.reverse !== '') {
			reverse = this.props.settings.general.reverse;
		}
        
        //point of execution
        if(typeof this.props.settings.general.triggerElement != undefined) {
			triggerElement = this.props.settings.general.triggerElement;
		}
        if(triggerElement == 'top-document') {
            triggerElement = '#bbsm-trigger-top-document';
        } else {
            triggerElement = "#bb-vcvs-demo-element-trigger";
        }
        

		if(typeof this.props.settings.ease.duration != undefined && this.props.settings.ease.duration != '') {
			durationEase = this.props.settings.ease.duration;
		}
        
        window.controller = new ScrollMagic.Controller({
            container: "#bb-scroll-preview-container",
        });
        window.controller_h = new ScrollMagic.Controller({
            container: "#bb-scroll-preview-container",
            vertical: false
        });
        window.scene = new ScrollMagic.Scene({
			triggerElement: triggerElement,
			duration: duration,
			offset: offset,
			triggerHook: triggerHook,
			tweenChanges: true,
            reverse: reverse,
		})
		.setTween("#bb-vcvs-demo-element", durationEase, tweenSettings); // trigger a TweenMax.to tween

		if(typeof this.props.settings.bezier != undefined && this.props.settings.bezier.length > 0) {
			window.scene.setTween("#bb-vcvs-demo-element", durationEase, {css:{bezier: {curviness: 1.25, autoRotate: true,values: this.props.settings.bezier} }, ease: eval(this.props.settings.scroll.ease)});
		}

		if(typeof this.props.settings.general.pin != undefined && this.props.settings.general.pin == 'on') {
			window.scene.setPin("#bb-vcvs-demo-element", {pushFollowers:  eval(this.props.settings.general.pushFollowers)} );
		}

		if(typeof this.props.settings.class.classToggleEnable != undefined && this.props.settings.class.classToggleEnable == 'on') {
			window.scene.removeClassToggle(true);
			jQuery("#bb-vcvs-demo-element").attr('class', 'bb-vcvs-demo-element animated');
			window.scene.setClassToggle("#bb-vcvs-demo-element", this.props.settings.class.classCSS);
		}

		window.scene.addIndicators({name: durationString});
        
        if(vertical == 'on') {
            window.scene.addTo(window.controller);
        } else {
            window.scene.addTo(window.controller_h);
        }
	},

	initStyle: function(){
		var tweenSettings = {
            width: '',
            height: '',
            position: '',
            top: '',
            left: '',
            bottom: '',
            right: '',
            zIndex: '',
            
			x: 0,
			y: 0,
			z: 0,
			scaleX: 1,
			scaleY: 1,
			scaleZ: 1,
			rotation: 0,
			rotationX: 0,
			rotationY: 0,
			rotationZ: 0,
			skewX: 0,
			skewY: 0,
			backgroundColor: '',
			color: ''
		};
        
        if(typeof this.props.settings.init.width != undefined && this.props.settings.init.width != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {width: this.props.settings.init.width} );
		}
        if(typeof this.props.settings.init.height != undefined && this.props.settings.init.height != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {height: this.props.settings.init.height} );
		}
        if(typeof this.props.settings.init.zIndex != undefined && this.props.settings.init.zIndex != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {zIndex: this.props.settings.init.zIndex} );
		}
        
        if(typeof this.props.settings.init.overflow != undefined && this.props.settings.init.overflow != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {overflow: this.props.settings.init.overflow} );
		}
        
        if(typeof this.props.settings.init.position != undefined && this.props.settings.init.position != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {position: this.props.settings.init.position} );
		}
        if(typeof this.props.settings.init.top != undefined && this.props.settings.init.top != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {top: this.props.settings.init.top} );
		}
        if(typeof this.props.settings.init.left != undefined && this.props.settings.init.left != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {left: this.props.settings.init.left} );
		}
        if(typeof this.props.settings.init.bottom != undefined && this.props.settings.init.bottom != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {bottom: this.props.settings.init.bottom} );
		}
        if(typeof this.props.settings.init.right != undefined && this.props.settings.init.right != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {right: this.props.settings.init.right} );
		}

		if(typeof this.props.settings.init.x != undefined && this.props.settings.init.x != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {x: this.props.settings.init.x} );
		}
		if(typeof this.props.settings.init.y != undefined && this.props.settings.init.y != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {y: this.props.settings.init.y} );
		}
		if(typeof this.props.settings.init.z != undefined && this.props.settings.init.z != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {z: this.props.settings.init.z} );
		}
        
		if(typeof this.props.settings.init.scaleX != undefined && this.props.settings.init.scaleX != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {scaleX: this.props.settings.init.scaleX} );
		}
		if(typeof this.props.settings.init.scaleY != undefined && this.props.settings.init.scaleY != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {scaleY: this.props.settings.init.scaleY} );
		}
		if(typeof this.props.settings.init.scaleZ != undefined && this.props.settings.init.scaleZ != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {scaleZ: this.props.settings.init.scaleZ} );
		}
        
		if(typeof this.props.settings.init.rotation != undefined && this.props.settings.init.rotation != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotation: this.props.settings.init.rotation} );
		}
		if(typeof this.props.settings.init.rotationX != undefined && this.props.settings.init.rotationX != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotationX: this.props.settings.init.rotationX} );
		}
		if(typeof this.props.settings.init.rotationY != undefined && this.props.settings.init.rotationY != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotationY: this.props.settings.init.rotationY} );
		}
		if(typeof this.props.settings.init.rotationZ != undefined && this.props.settings.init.rotationZ != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {rotationZ: this.props.settings.init.rotationZ} );
		}
        
		if(typeof this.props.settings.init.skewX != undefined && this.props.settings.init.skewX != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {skewX: this.props.settings.init.skewX} );
		}
		if(typeof this.props.settings.init.skewY != undefined && this.props.settings.init.skewY != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {skewY: this.props.settings.init.skewY} );
		}
        
		if(typeof this.props.settings.init.backgroundColor != undefined && this.props.settings.init.backgroundColor != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {backgroundColor: this.props.settings.init.backgroundColor} );
		}
		if(typeof this.props.settings.init.color != undefined && this.props.settings.init.color != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {color: this.props.settings.init.color} );
		}
		if(typeof this.props.settings.init.opacity != undefined && this.props.settings.init.opacity != '') {
			tweenSettings = jQuery.extend( true, tweenSettings, {opacity: this.props.settings.init.opacity} );
		}
		TweenMax.to("#bb-vcvs-demo-element", 0, tweenSettings, 0);
	},

    render: function() {

        return (
            <div id="bb-scroll-preview" className="bb-col-preview">
                <div id="bb-vcvs-preview-container" className="bb-preview-container">
                    <h3 className="bb-title">
                        <span id="bb-vcvs-preview-expand" className="dashicons dashicons-editor-expand"></span>
                        <span>{this.props.text.livePreview}</span>
                    </h3>
                    <div id="bb-scroll-preview-container" className="inside">
                        <div id="bbsm-trigger-top-document"></div>
                        <div className="bb-vcvs-spacer"></div>
						<div id="bb-vcvs-demo-element-trigger"></div>
                        <div id="bb-vcvs-demo-element" className="bb-vcvs-demo-element animated"><span>Scroll Magic</span></div>
                        <p className="bb-vcvs-example-text">This this example text (without affect by ScrollMagic)</p>
						<div className="bb-vcvs-spacer s2"></div>
                    </div>

                </div>
            </div>
        );
    }
});

var BBSceneEditor = React.createClass({
    render: function() {
        return (<BBSceneSettings settings={this.props.settings} edit={BB_SCENE_EDIT_SETTINGS} text={BB_TRANSLATION}/>);
    }
});

ReactDOM.render(<BBSceneEditor settings={BB_SCENE_SETTINGS} edit={BB_SCENE_EDIT_SETTINGS} />, document.getElementById("BBSceneEditor"));
