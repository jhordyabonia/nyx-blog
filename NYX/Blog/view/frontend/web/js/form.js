define([
    'mage/url',
    'jquery',
    'ko',
    'Magento_Checkout/js/model/error-processor',
    'NYXBlog_comment',
    'uiComponent'
],
function (Url,$, ko, errorProcessor,comments, Component) {
    'use strict';
    return Component.extend ({
        defaults: {
            message: ko.observable(''),
            messageClass: ko.observable(''),
            title: ko.observable(''),
            email: ko.observable(''),
            comment: ko.observable(''),
            postList: ko.observableArray([]), 
            popupComments: comments().initialize()
        },
        initialize: function () {
            this._super();
            this.getPosts();
            this.message.subscribe(this.hideMesaage,this);            
            return this;
        },
        hideMesaage:function(){
            setTimeout(function(form){
                form.message('');
            },4500,this);
        },
        getPosts: function() {
            this.postList([]);
            let _self = this;
            let url = Url.build('blog/post/get');
            let request = {method: 'GET'};

            $('body').trigger('processStart');

            fetch(url, request).then((result) => {
                $('body').trigger('processStop');
                if (result.ok) {
                    result.json().then((resultJSON) => {
                        resultJSON.forEach(post => _self.postList.push(post));
                    });
                }
            }).catch((error) => {
                errorProcessor.process(error);
            });
        },   
        getUrl:function(uri){
            return Url.build(window.URL_MEDIA+uri);
        },
        validateEmail:function(){
            let email = this.email();
            if(email.length == 0){
                return false;
            }
            if(email.indexOf('@')==-1){
                this.message('Invalid Email, email is should to have "@"');
                this.messageClass('message error');
                return false;
            }
            if(!email.indexOf('.')==-1){
                this.message('Invalid Email, use like jhondoe@test.com');
                this.messageClass('message error');
                return false;
            }
            return email;
        },
        canSend:function(){
            this.message('');
            return this.title()
                    &&this.comment()
                    &&this.validateEmail();
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
            let url = Url.build('blog/post/create');
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
                            _self.title('');
                            _self.email('');
                            _self.comment('');
                            _self.getPosts();
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
