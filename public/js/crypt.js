var Crypt = function() {
    var alphabet = 'abcdefghijklmnopqrstuvwxyz'.split(''),
        upperAlphabet = alphabet.map(function(letter) {
            return letter.toUpperCase();
        });

    var map = { };

    function addToMap(letters) {
        letters.map(function(letter) {
            if(!map.hasOwnProperty(letter))
                map[letter] = letter;
        });
    };

    addToMap(alphabet);

    var form, sourceText, targetText;
    var addInput = function(letter) {
        var div = document.createElement('div');
        var input = document.createElement('input'),
            label = document.createElement('label');

        label.innerHTML = letter;

        var targetLetter;
        if(map.hasOwnProperty(letter))
            targetLetter = map[letter];
        else
            targetLetter = letter;

        input.setAttribute('type', 'text');
        input.setAttribute('name', letter);
        input.setAttribute('placeholder', letter);
        input.value = targetLetter;

        div.appendChild(label);
        div.appendChild(input);
        form.appendChild(div);

        var action = function(event) {
            var target = event.target;

            if(target.type == 'text') {
                map[target.name] = target.value;
            }
            decode();
        };
        form.addEventListener('change', action, true);
        form.addEventListener('keyup', action, true);
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            decode();
        }, true);
    };

    this.init = function() {
        form = document.getElementById('cipher-form');
        alphabet.map(addInput);
        form.appendChild(document.createElement('hr'));

        sourceText = document.createElement('textarea');
        sourceText.setAttribute('name', 'source');
        sourceText.setAttribute('rows', 10);
        sourceText.setAttribute('cols', 50);
        sourceText.innerText = 'nvrrulap,ArpUbTuipXtujqpQvbkiTxlusui,TpGuiHubpiaxktlVoKuDjtpiuTxwvboaituOuiDjrrtuIuKurux.TxOtdxUxigvjptapouGakTcUuxIupiduLupijjbk.OuiKuYtdluhvulkuTxwvboaituOvuiuxDjrrtuHubkubCjxxux.Pvbbe.Lb.DjwwbvjqdaxxtuQqq.ovytruwtpg.nvo';
        form.appendChild(sourceText);

        targetText = document.createElement('textarea');
        targetText.setAttribute('name', 'targetText');
        targetText.setAttribute('rows', 10);
        targetText.setAttribute('cols', 50);
        form.appendChild(targetText);

        var submit = document.createElement('input');
        submit.setAttribute('type', 'submit');
        submit.setAttribute('value', 'Decode');
        form.appendChild(submit);

        var loadButton = document.createElement('button');
        loadButton.innerHTML = 'Load JSON';
        loadButton.addEventListener('click', function() {
            try {
                var data = JSON.parse(prompt('Plak je JSON hier'));
            } catch(e) {
                alert('JSON laden is mislukt.');
            }
            if(data) load(data);
        }, true);
        form.appendChild(loadButton);

        this.decode();

        var dumpButton = document.createElement('button');
        dumpButton.innerHTML = 'Dump JSON to console';
        dumpButton.addEventListener('click', function() {
            console.log(JSON.stringify(map, undefined, 1));
        });
        form.appendChild(dumpButton);
    }

    var load = this.load = function(data) {
        map = data;
        decode();
    };

    var decode = this.decode = function() {
        var source = sourceText.value.split(''), result;
        if(source.length == 0)
            return;

        result = source.map(function(letter) {
            var lowerLetter = letter.toLowerCase();
            if(map.hasOwnProperty(letter)) {
                return map[letter];
            } else if(map.hasOwnProperty(lowerLetter)) {
                return map[lowerLetter].toUpperCase();
            }
            return letter;
        }).join('');

        targetText.value = result;
    };
};

document.addEventListener("DOMContentLoaded", function(e) {
    new Crypt().init();
}, true);
