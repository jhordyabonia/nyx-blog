define([
    'mage/url',
    'jquery',
    'ko',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Ui/js/modal/modal',
    'uiComponent'
],
function (Url,$, ko, errorProcessor, modal,Component) {
    'use strict';
    return Component.extend ({
        defaults: {
            message: ko.observable(''),
            messageClass: ko.observable(''),
            post_id: ko.observable(''),
            comment_autor: ko.observable(''),
            comment_body: ko.observable(''),
            commentList: ko.observableArray([]),
            modal:null
        },
        initialize: function () {
            this._super();
            this.message.subscribe(this.hideMessage,this);     
            this.post_id.subscribe(this.getComments,this);
            this.makePopup() 
            return this;
        },
        hideMessage:function(){
            setTimeout(function(form){
                form.message('');
            },4500,this);
        },
        makePopup:function(){
            if(this.modal){
                return;
            }
            let _self = this
            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                clickableOverlay: false,
                modalClass: 'wrap-modal-flex',
                title: '',
                buttons: [{
                    text: $.mage.__('Cerrar'),
                    class: 'action primary btn-popup-store-pickup',
                    click: function () {
                        _self.modal.closeModal();
                    }
                }]
            };       

            this.modal = modal(options, $('.comment-list-wrapper'));
        },
        isActive:function() {
            return this.storePickupSelected();
        },
        getComments: function() {
            this.commentList([]);
            let _self = this;
            let url = Url.build('blog/comment/get?post_id='+this.post_id());
            let request = {method: 'GET'};

            $('body').trigger('processStart');

            fetch(url, request).then((result) => {
                $('body').trigger('processStop');
                if (result.ok) {
                    result.json().then((resultJSON) => {
                        resultJSON.forEach(post => _self.commentList.push(post));
                    });
                    
                    if(_self.modal){
                       $('.comment-list-wrapper').modal('openModal');
                    }
                }
            }).catch((error) => {
                errorProcessor.process(error);
            });
            return this
        },   
        getUrl:function(uri){
            return Url.build(window.URL_MEDIA+uri);
        },
        canSend:function(){
            this.message('');
            return this.title()
                    &&this.comment();
        },
        getData:function(){
            var data ={
            'post_title':this.title(),
            'post_details':this.comment(),
            'post_email':this.email(),
            'form_key':$.cookie('form_key')
            };

            /*$.each($('[name="post_file"]')[0].files, function(i, file) {
                data.append('post_file', file);
                console.log(file);
            });*/
            return JSON.stringify(data);
        },
        submit: function() {
            let _self = this;
            let url = Url.build('blog/comment/create');
            let request = {
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: _self.getData()
            };

            $('body').trigger('processStart');
            fetch(url, request).then((result) => {                
                result.json().then(
                    (_request) => {
                        $('body').trigger('processStop');
                        if(_request.ok){
                            _self.comment_autor('');
                            _self.comment_body('');
                            //_self.comment_id('');
                            _self.getComments();
                            _self.message(_request.message);
                            _self.messageClass('message success');
                        }else{
                            _self.message(_request.message);
                            _self.messageClass('message error');
                        }
                    }
                );                
            }).catch((error) => {
                _self.message(error);
                _self.messageClass('message error');
            });
        }    
    });
});
