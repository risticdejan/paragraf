$.validator.addMethod("phone", function (value, element) {
    return this.optional(element) || /^[0-9\-\(\)\/\+\s]*$/im.test(value);
}, "Telefonski broj nije ispravan");

$.validator.addMethod("alphaspace", function (value, element) {
    return this.optional(element) || /^[\p{L}\s]+$/uim.test(value);
}, "Polje je može da sadrži samo slova");

$.validator.addMethod("passport", function (value, element) {
    return this.optional(element) || /^[0-9]{9}$/uim.test(value);
}, "Broj pasoš nije ispavan, sastoji se od 9 cifara");

$.validator.addMethod("datebefore", function (value, element,param) {
    return this.optional(element) || (new Date(value)) <= (new Date(param));
}, "Datum mora biti pre {0}");

$.validator.addMethod("dateafter", function (value, element,param) {
        return this.optional(element) || (new Date(param)) <= (new Date(value));
}, "Datum nemože biti pre {0}");

var Prijava = {
    dateInterval: false,

    config: {
        addition: "#addition",
        additionButton: "#addition-button",
        indOpition: ".ind-opt",
        gruOpition: ".gru-opt",
        datePolaska: '#datum_polaska',
        dateDolaska: '#datum_dolaska',
        dateInfo: '.date-info',
        form: '#prijava-forma',
        rules: {
            puno_ime: {
                required: true,
                alphaspace: true,
                minlength: 4,
                maxlength: 64
            },
            datum_rodjenja: {
                required: true,
                date: true,
                datebefore: (new Date()).toLocaleDateString()
            },
            broj_pasosa: {
                required: true,
                passport: true
            },
            telefon: {
                phone: true
            },
            email: {
                required: true,
                email: true
            },
            datum_polaska: {
                required: true,
                date: true,
                dateafter: (new Date()).toLocaleDateString()
            },
            datum_dolaska: {
                required: true,
                date: true,
                dateafter: (new Date()).toLocaleDateString()
            },
            tip_polise: {
                required: true
            }
        }
    },

    init: function (config) {
        $.extend(this.config, config);

        this.bindEvents();
    },

    bindEvents: function () {
        var config = this.config,
            $additionButton = $(config.additionButton),
            $addition = $(config.addition),
            $indOpition = $(config.indOpition),
            $gruOpition = $(config.gruOpition),
            $datePolaska = $(config.datePolaska),
            $dateDolaska = $(config.dateDolaska),
            $form = $(config.form);

        $indOpition.on("click", $.proxy(this.hideAdditon,this));
        $gruOpition.on("click", $.proxy(this.showAddition,this));   
        $additionButton.on("click", $.proxy(this.add, this));
        $addition.on("click","a.removeItem", this.remove);
        $addition.on("keyup input","input", this.updateData);
        $datePolaska.on('input', $.proxy(this.setDateInfo,this));
        $dateDolaska.on('input', $.proxy(this.setDateInfo,this));

        $form.find('button').on('click', $.proxy(this.send, this));
        $form.on('focus', 'input', this.removeError);
    },

    send: function(e){
        var config = this.config,
                $form = $(config.form),
                data = $form.serialize(),
                url = $form.attr('action'),
                rules = config.rules ;

        this.removeError(e,true);

        validator = this.validateForm(config.form, rules);

        if (validator.form() && this.dateInterval) {
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                dataType: 'JSON'
            }).done(function (data) {
                if(data.status === 'success'){
                    $form[0].reset();
                    window.location.href = data.url;
                } else {
                    
                    for(let prop in data.error) {
                        if(typeof data.error[prop] === 'object') {
                            for(let item in data.error[prop]) {
                                let index = item.replace('o','');
                                let errors = data.error[prop][item];
                                Osiguranik.updateFieldError(index, errors)
                                for(let p in data.error[prop][item]){
                                    $('#' + p + '_' + item)
                                        .closest('div')
                                        .append(Template.errorField(data.error[prop][item][p]));
                                }
                            }
                        } else {
                            $('#' + prop).closest('div')
                                        .append(Template.errorField(data.error[prop]));
                        }
                    };
                }
            });
        }

        e.preventDefault();
        e.stopPropagation();
    },

    validateForm: function (form, rules) {
        return $(form).validate({
            ignore: "",
            lang: 'sr',
            rules: rules,
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    },

    removeError: function (e,all) {
        if(all){
            $('div.invalid-feedback').remove();
        } else {
            $(this).closest('div')
                .find('div.invalid-feedback')
                .remove();
        }
    },

    hideAdditon: function(e) {
        var config = this.config,
            $addition = $(config.addition),
            $additionButton = $(config.additionButton);

        $addition.empty().hide();
        $additionButton.hide();

        Osiguranik.clear();

        e.stopPropagation();
    },

    showAddition: function(e) {
        var config = this.config,
            $addition = $(config.addition),
            $additionButton = $(config.additionButton);

        $addition.show();
        $additionButton.show();
        e.stopPropagation();
    },

    add: function(e) {
        let index = Osiguranik.add();

        this.update();
        this.addRule(index);

        e.preventDefault();
        e.stopPropagation();
    },

    remove: function(e) {
        var $parent = $(this).parents("div").eq(0),
            index = $parent.data('index');

        Osiguranik.remove(index);
        
        Prijava.update();
        Prijava.updateRules();

        e.preventDefault();
        e.stopPropagation();
    },

    update: function(){
        var config = this.config,
            $addition = $(config.addition);

        $addition
            .empty()
            .html(
                Template.update(Osiguranik.data)
            );
    },

    updateData: function(){
        var $el = $(this),
            id = $el.attr('id'),
            value = $el.val();
            index = parseInt(id.slice(id.lastIndexOf("_o")+2))
            field = id.slice(0,id.lastIndexOf("_"));

        Osiguranik.updateField(index, field, value);
    },

    updateRules: function(){
        var config = this.config,
            length = Osiguranik.data.length;

        for(let prop in config.rules){
            let start = prop.indexOf('[o') + 2;
            let end = prop.indexOf(']');
            if(prop.slice(start, end) >= length){
                delete config.rules[prop];
            }
        }
    },

    addRule: function(index){
        this.config.rules['osiguranik[o'+index+'][puno_ime]'] = {
            required: true,
            alphaspace: true,
            minlength: 4,
            maxlength: 64
        }
        this.config.rules['osiguranik[o'+index+'][datum_rodjenja]'] = {
            required: true,
            date: true,
            datebefore: (new Date()).toLocaleDateString()
        }
        this.config.rules['osiguranik[o'+index+'][broj_pasosa]'] = {
            required: true,
            passport: true
        }
    },

    setDateInfo: function(){
        var config = this.config,
            info = '', cssClass="",
            $dateInfo = $(config.dateInfo),
            polazak = $(config.datePolaska).val(),
            dolazak = $(config.dateDolaska).val();

        $dateInfo.empty();
        
        if(polazak != '' && dolazak) {
            var p = new Date(polazak);
            var d = new Date(dolazak);

            var razlika = d.getTime() - p.getTime();

            if(razlika <= 0) {
                this.dateInterval = false;
                info = 'datum polaska mora biti pre datuma dolaska.';
                cssClass = 'text-danger';
            } else {
                this.dateInterval = true;
                var dani = razlika / (1000 * 3600 * 24);
                info = 'trajanje putovanja je ' + dani + ' dana.';
                cssClass = 'text-info';
            }
            $dateInfo.empty().html(Template.dateInfo(info,cssClass));
        }
    }
}

Prijava.init();

var Osiguranik = {
    pos: 0,
    data: [],

    clear: function() {
        this.pos = 0;
        this.data = [];
    },

    add: function() {

        var obj = {
            index: this.pos,
            fields: {
                puno_ime: '',
                datum_rodjenja: '',
                broj_pasosa: ''
            },
            errors: {

            }
        }
        this.pos++;

        this.data.push(obj);

        return obj.index;
    },

    remove: function(index){
        this.data = this.data.filter(function(obj){
            return obj.index != index;
        });
        this.updatePos();
    },

    updatePos: function() {
        var pos = 0;

        this.data = this.data.map(function(obj){
            obj.index = pos;
            pos++;
           return obj;
        });
        this.pos = pos;
    },

    updateField: function(index, field, value){
        this.data.forEach(element => {
            if(element.index == index){
                element.fields[field] = value;
                delete element.errors[field];
            }
        });
    },

    updateFieldError: function(index, errors){
        this.data.forEach(element => {
            if(element.index == index){
                element.errors = errors;
            }
        });
    }

}

var Template = {

    dateInfo: function(text, cssClass) {
        var temp = "";
        temp += "<span class='"+cssClass+"'>";
        temp += text;
        temp += "</span>";
        return temp;
    },

    errorField: function (error) {
        var temp = "";
        temp += "<div class='invalid-feedback' style='display: block;'>";
        temp += error;
        temp += "</div>";
        return temp;
    },

    update: function(data) {
        var self = this,
            temp = '';

        data.forEach(function(obj) {
            temp += self.fields(obj);
        });

        return temp;
    },

    fields: function(obj) {
        var temp = '';

        temp += '<div class="addition-item" data-index="'+obj.index+'">';
        temp += '<h3>Osiguranik ' + (obj.index+1) + ' ';
        temp += '<a href="#" class="btn btn-outline-danger btn-sm float-right removeItem">izbaci osiguranika</a>';
        temp += '</h3>';
        temp += '<div class="form-group">';
        temp += '<label for="puno_ime_o'+obj.index+'">Ime i prezime: <span class="text-danger">*</span></label>';
        temp += '<input type="text"  class="form-control" id="puno_ime_o'+obj.index+'" name="osiguranik[o'+obj.index+'][puno_ime]" value="'+obj.fields.puno_ime+'">'; 
        temp += (obj.errors.puno_ime) ? Template.errorField(obj.errors.puno_ime) : '';
        temp += '</div>';
        temp += '<div class="form-group">';
        temp += '<label for="datum_rodjenja_o'+obj.index+'">Datum rodjenja: <span class="text-danger">*</span></label>';
        temp += '<input type="date" class="form-control" id="datum_rodjenja_o'+obj.index+'" name="osiguranik[o'+obj.index+'][datum_rodjenja]" value="'+obj.fields.datum_rodjenja+'">';
        temp += (obj.errors.datum_rodjenja) ? Template.errorField(obj.errors.datum_rodjenja) : '';
        temp += '</div>';
        temp += '<div class="form-group">';
        temp += '<label for="broj_pasosa_o'+obj.index+'">Broj pasoša: <span class="text-danger">*</span></label>';
        temp += '<input type="text" class="form-control" id="broj_pasosa_o'+obj.index+'" name="osiguranik[o'+obj.index+'][broj_pasosa]" value="'+obj.fields.broj_pasosa+'">';
        temp += (obj.errors.broj_pasosa) ? Template.errorField(obj.errors.broj_pasosa) : '';
        temp += '</div>';    
        temp += '</div>';

        return temp;
    }
}