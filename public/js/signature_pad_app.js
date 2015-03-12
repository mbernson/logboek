var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    var ratio =  window.devicePixelRatio || 1;
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas, {
  minWidth: 1,
  maxWidth: 3,
  penColor: "rgb(0, 0, 0)"
});

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
    document.getElementById('submit').style.visibility = 'hidden';
});

saveButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        alert("Ondertekenen eerst om verder te gaan.");
    } else {
      var hidden_input = document.getElementById('sign');
      hidden_input.setAttribute('value', signaturePad.toDataURL());

      document.getElementById('submit').style.visibility = 'visible';
    }
});
