$(document).ready(function(){
  // Mouse Controls
  var documentWidth = document.documentElement.clientWidth;
  var documentHeight = document.documentElement.clientHeight;
  var cursorX = documentWidth / 2;
  var cursorY = documentHeight / 2;

  function resetPartOfSkinMethod(data, obj, group)
  {
    $("." + obj).attr("max", data.max)
    $("." + obj).attr("min", 0)
    $("." + obj).attr("value", data.actual)
  }

  function resetPartOfSkin(raw, obj, group)
  {
    resetPartOfSkinDecoded(JSON.parse(raw), obj, group)
  }

  function resetPartOfSkinDecoded(data, obj, group)
  {
    original_data = data
    if (original_data.obj1 != null)
    {
      resetPartOfSkinMethod(original_data.obj1, obj, group)
    }
    if (original_data.obj2 != null)
    {

      resetPartOfSkinMethod(original_data.obj2, "2"+obj, "2"+group)
    }
    if (original_data.obj3 != null)
    {
      resetPartOfSkinMethod(original_data.obj3, "3"+obj, "3"+group)
    }
    if (original_data.obj4 != null)
    {
      resetPartOfSkinMethod(original_data.obj4, "4"+obj, "4"+group)
    }
  }

  function resetEstheticien()
  {
    $.post('http://skincreator/loadSkinComponents', JSON.stringify({
     
    }), function(result) {
      xDatas = JSON.parse(result)
      for (const [key, value] of Object.entries(xDatas)) {
        // console.log(`${key}: ${value}`);
        if (key == 'makeup')
        {
          resetPartOfSkinDecoded(value, "MakeupArray", "MakeupArrayNtm")
        }
        if (key == 'lipstick')
        {
          resetPartOfSkinDecoded(value, "NTMLipstick", "LipstickArrayNtm")
        }
        if (key == 'blush')
        {
          resetPartOfSkinDecoded(value, "NTMBlush", "BlushArrayNtm")
        }
        if (key == 'tshirt')
        {
          resetPartOfSkinDecoded(value, "NTMtshirt", "TshirtArrayNtm")
        }
        if (key == 'torso')
        {
          resetPartOfSkinDecoded(value, "NTMtorso", "TorsoArrayNtm")
        }
        if (key == 'pantalon')
        {
          resetPartOfSkinDecoded(value, "NTMpantalon", "PantalonArrayNtm")
        }
        if (key == 'shoes')
        {
          resetPartOfSkinDecoded(value, "NTMshoes", "ShoesArrayNtm")
        }
        if (key == 'lunette')
        {
          resetPartOfSkinDecoded(value, "NTMlunettes", "NTMlunettesArray")
        }
        if (key == 'ears')
        {
          resetPartOfSkinDecoded(value, "NTMoreilles", "NTMoreillesArray")
        }
        if (key == 'hat')
        {
          resetPartOfSkinDecoded(value, "NTMChoipeaux", "NTMChoipeauxArray")
        }
        if (key == 'mask')
        {
          resetPartOfSkinDecoded(value, "NTMMask", "NTMMaskArray")
        }
        if (key == 'arms')
        {
          resetPartOfSkinDecoded(value, "NTMArms", "ArmsArrayNtm")
        }
        if (key == 'bag')
        {
          resetPartOfSkinDecoded(value, "NTMbag", "bagArrayNtm")
        }
        if (key == 'watches') // Main Droite
        {
          resetPartOfSkinDecoded(value, "NTMWatches", "NTMWatches2")
        }
        if (key == 'bracelets') // Main Gauche
        {
          resetPartOfSkinDecoded(value, "NTMbracelets", "NTMbracelets2")
        }
        if (key == 'chain') 
        {
          resetPartOfSkinDecoded(value, "NTMaccessory", "NTMaccessory2")
        }
      }
    });
  }

  
  function reloadThisItems()
  {
    // resetTorso()
    // resetTshirt()
    // resetShoes()
    // resetPantalon()
    // resetLunettes()
    // resetBijouxOreilles()
    // resetChoipeaux()
    // resetMask()
    // resetArms()
    resetEstheticien()
  }

  function reset()
  {
    reloadThisItems()
  }


  function triggerClick(x, y) {
    var element = $(document.elementFromPoint(x, y));
    element.focus().click();
    return true;
  }

  function removeActive(defaultName)
  {
      var elementDefault = document.getElementById(defaultName);
      elementDefault.classList.remove("active");
  }

  function addActive(newName)
  {
      var elementDefault = document.getElementById(newName);
      elementDefault.classList.add("active");
  }
  function fixLabel(newName, id, max)
  {
    $(newName).parent().prev().text(id+'/'+max);
  }

  function updateCloth(defaultName, newName, id, max)
  {
      if (document.getElementById(newName) != null)
      {
        removeActive(defaultName)
        addActive(newName)
        fixLabel(newName, id, max)
      }
  }


  // Listen for NUI Events
  window.addEventListener('message', function(event){
// Open Skin Creator
   if(event.data.openSkinCreator == true){
     reset()
    if (event.data.skin != null)
    {
      console.log(event.data.skin)

      var skin = event.data.skin
      $(".gent").val(1);
      if (event.data.skin.isMale) {
        $(".gent").val(0);
      }
      
      $( "input[id=pere"+(event.data.skin.head.skinPartPedHeadShapeFirstID+1)+"]").attr("checked", true);
      $( "input[id=mere"+event.data.skin.head.skinPartPedHeadShapeSecondID+"]").attr("checked", true);
      $('.morphologie').val(event.data.skin.head.skinPartPedHeadShapeMix);
      $( "input[id=eye"+(event.data.skin.eyecolor.primary_color+1)+"]").attr("checked", true);
      $( "input[id=peaucolor_dad"+(event.data.skin.head.skinPartPedHeadSkinFirstID)+"]").attr("checked", true);
      $( "input[id=peaucolor_mom"+(event.data.skin.head.skinPartPedHeadSkinSecondID)+"]").attr("checked", true);
      
      $( "input[id=p"+(skin['skin'])+"]").attr("checked", true);
      $('.acne').val(skin['acne']);
      $('.pbpeau').val(skin['complexion_1']);
      $('.tachesrousseur').val(skin['moles_1']);
      $('.rides').val(event.data.skin.age.type);
      $('.intensiterides').val(event.data.skin.age.opacity);


      $('.hair').val(skin['hair_1']);
      $('input[id=c'+skin['hair_color_1']+']').attr("checked", true);
      $('input[id=ct'+skin['hair_color_2']+']').attr("checked", true);

      $('.sourcils').val(skin['eyebrows_1']);
      $('.epaisseursourcils').val(skin['eyebrows_2']);

      $('.barbe').val(skin['beard_1']);
      $('.epaisseurbarbe').val(skin['beard_2']);
      $( "input[id=bc"+(skin['beard_3'])+"]").attr("checked", true);

      updateCloth("chapeau0", "chapeau"+event.data.skin.hat.type, event.data.skin.hat.type, 32);
      updateCloth("lunette0", "lunette"+event.data.skin.glasse.type, event.data.skin.glasse.type, 11); 
      updateCloth("oreille0", "oreille"+event.data.skin.ear.type, event.data.skin.ear.type, 15);
      updateCloth("tshirt0", "tshirt"+event.data.skin.top.type, event.data.skin.top.type, 188);
      updateCloth("pantalon0", "pantalon"+event.data.skin.leg.type, event.data.skin.leg.type, 57);
      updateCloth("chaussure0", "chaussure"+event.data.skin.shoe.type, event.data.skin.shoe.type, 50);
      updateCloth("montre0", "montre"+event.data.skin.watch.type, event.data.skin.watch.type, 7);
    }
    if ($(".vetements").hasClass('active'))
    {
      $(".vetements").removeClass('active')
    }
    if ($(".visage").hasClass('active'))
    {
      $(".visage").removeClass('active')
    }
    if ($(".pilosite").hasClass('active'))
    {
      $(".pilosite").removeClass('active')
    }
    $(".vetements").hide();
    $(".pilosite").hide();
    $(".visage").hide();
    $(".Choipeaux").hide();
    $(".lunettes").hide();
    $(".BijouxOreilles").hide();
    $(".bijouxMontres").hide();
    $(".Mask").hide();
    $(".Estheticien").hide();
    $(".Bijouterie").hide();


    $(".block").hide();
    
    if (event.data.showMorph != null && event.data.showMorph)
    {
      $(".visage").addClass('active')
      $(".visage").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'visage'
      }));
      if (event.data.showHair != null && event.data.showHair)
      {
        $(".tab .pilosite").show();
      }
      if (event.data.showCloth != null && event.data.showHair)
      {
        $(".tab .vetements").show();
      }
      if (event.data.showLunettes != null && event.data.showLunettes)
      {
        $(".tab .lunettes").show();
      }
      if (event.data.showEars != null && event.data.showEars)
      {
        $(".tab .BijouxOreilles").show();
      }
      if (event.data.showChapeau != null && event.data.showChapeau)
      {
        $(".tab .Choipeaux").show();
      }
      if (event.data.showMask != null && event.data.showMask)
      {
        $(".tab .Mask").show();
      }
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showHair != null && event.data.showHair)
    {
      $(".visage").hide();
    
      $(".pilosite").addClass('active')
      $(".pilosite").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'pilosite'
      }));
      if (event.data.showCloth != null && event.data.showCloth)
      {
        $(".tab .vetements").show();
      }
      if (event.data.showLunettes != null && event.data.showLunettes)
      {
        $(".tab .lunettes").show();
      }
      if (event.data.showEars != null && event.data.showEars)
      {
        $(".tab .BijouxOreilles").show();
      }
      if (event.data.showChapeau != null && event.data.showChapeau)
      {
        $(".tab .Choipeaux").show();
      }
      if (event.data.showMask != null && event.data.showMask)
      {
        $(".tab .Mask").show();
      }
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
      
    }
    else if (event.data.showCloth != null && event.data.showCloth)
    {

      $(".vetements").addClass('active')
      $(".vetements").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'vetements'
      }));
      if (event.data.showLunettes != null && event.data.showLunettes)
      {
        $(".tab .lunettes").show();
      }
      if (event.data.showEars != null && event.data.showEars)
      {
        $(".tab .BijouxOreilles").show();
      }
      if (event.data.showChapeau != null && event.data.showChapeau)
      {
        $(".tab .Choipeaux").show();
      }
      if (event.data.showMask != null && event.data.showMask)
      {
        $(".tab .Mask").show();
      }
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showLunettes != null && event.data.showLunettes)
    {
      $(".lunettes").addClass('active')
      $(".lunettes").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'pilosite'
      }));
      if (event.data.showEars != null && event.data.showEars)
      {
        $(".tab .BijouxOreilles").show();
      }
      if (event.data.showChapeau != null && event.data.showChapeau)
      {
        $(".tab .Choipeaux").show();
      }
      if (event.data.showMask != null && event.data.showMask)
      {
        $(".tab .Mask").show();
      }
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showEars != null && event.data.showEars)
    {
      $(".BijouxOreilles").addClass('active')
      $(".BijouxOreilles").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'pilosite'
      }));
      if (event.data.showChapeau != null && event.data.showChapeau)
      {
        $(".tab .Choipeaux").show();
      }
      if (event.data.showMask != null && event.data.showMask)
      {
        $(".tab .Mask").show();
      }
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showChapeau != null && event.data.showChapeau)
    {
      $(".Choipeaux").addClass('active')
      $(".Choipeaux").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'pilosite'
      }));
      if (event.data.showMask != null && event.data.showMask)
      {
        $(".tab .Mask").show();
      }
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showMask != null && event.data.showMask)
    {
      $(".Mask").addClass('active')
      $(".Mask").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'pilosite'
      }));
      if (event.data.showEstheticien != null && event.data.showEstheticien)
      {
        $(".tab .Estheticien").show();
      }
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showMask != null && event.data.showMask)
    {
      $(".Estheticien").addClass('active')
      $(".Estheticien").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'pilosite'
      }));
      if (event.data.showBijouterie != null && event.data.showBijouterie)
      {
        $(".tab .Bijouterie").show();
      }
    }
    else if (event.data.showBijouterie != null && event.data.showBijouterie)
    {
      $(".Bijouterie").addClass('active')
      $(".Bijouterie").show();
      $.post('http://skincreator/zoom', JSON.stringify({
        zoom: 'vetements'
      }));
    }
   
    $(".skinCreator").css("display","block");
    $(".rotation").css("display","flex");
  }
   // Close Skin Creator
   if(event.data.openSkinCreator == false){
     $(".skinCreator").fadeOut(400);
     $(".skinCreator").css("display","none");
     $(".rotation").css("display","none");
   }

    // Click
    if (event.data.type == "click") {
      triggerClick(cursorX - 1, cursorY - 1);
    }
  });


  function loadData(val)
  {
    var datas = {
      head: {
        skinPartPedHeadShapeFirstID: $('input[name=pere]:checked', '#formSkinCreator').val(),
        skinPartPedHeadShapeSecondID: $('input[name=mere]:checked', '#formSkinCreator').val(),
        skinPartPedHeadShapeMix: $('.morphologie').val(),
        skinPartPedHeadSkinFirstID: $('input[name=peaucolor_dad]:checked', '#formSkinCreator').val(),
        skinPartPedHeadSkinSecondID: $('input[name=peaucolor_mom]:checked', '#formSkinCreator').val(),
        skinPartPedHeadSkinMix: $('.peaucolor_mix').val(),
      },
      face: {
        eyecolor: {
          primary_color: $('input[name=eyecolor]:checked','#formSkinCreator').val(),
          secondary_color: $('.lentilles .active').attr('data')
        },
        haircut: {
          type: $('.hair').val(),
          primary_color: $('input[name=haircolor]:checked', '#formSkinCreator').val(),
          secondary_color: $('input[name=haircolor2]:checked', '#formSkinCreator').val(),
        },
        beard: {
          type: $('.barbe').val(),
          opacity: $('.epaisseurbarbe').val(),
          primary_color: $('input[name=barbecolor]:checked', '#formSkinCreator').val(),
          secondary_color: $('input[name=barbecolor]:checked', '#formSkinCreator').val(),
        },
        eyebrow: {
          type: $('.sourcils').val(),
          opacity: $('.epaisseursourcils').val(),
        },
        makeup: {
          type: $('.MakeupArray').val(),
          opacity: $('.2MakeupArray').val(),
          primary_color: $('.3MakeupArray').val(),
          secondary_color: $('.4MakeupArray').val(),
        },
        lipstick: {
          type: $('.NTMLipstick').val(),
          opacity: $('.2NTMLipstick').val(),
          primary_color: $('.3NTMLipstick').val(),
          secondary_color: $('.4NTMLipstick').val(),
        },
        blush: {
          type: $('.NTMBlush').val(),
          opacity: $('.2NTMBlush').val(),
          primary_color: $('.3NTMBlush').val(),
          secondary_color: $('.4NTMBlush').val(),
        },
        age: { 
          type:  $('.rides').val(),
          opacity:  $('.intensiterides').val(),
        },
      },
      cloth: {
        leg: {
          type:  $(".NTMpantalon").val(),
          alteration:  $(".2NTMpantalon").val(),
        },
        shoe: {
          type:  $(".NTMshoes").val(),
          alteration:  $(".2NTMshoes").val(),
        },
        bag: {
          type: $(".NTMbag").val(),
          alteration: $(".2NTMbag").val(),
        },
        undershirt: {
          type: $(".NTMArms").val(),
          alteration: $(".2NTMArms").val(),
        },
        torso: {
          type: $(".NTMtorso").val(),
          alteration: $(".2NTMtorso").val(),
        },
        top: {
          type: $(".NTMtshirt").val(),
          alteration: $(".2NTMtshirt").val(),
        },
        mask: {
          type: $(".NTMMask").val(),
          alteration: $(".2NTMMask").val(),
        },
        accessory: {
          type: $(".NTMaccessory").val(),
          alteration: $(".2NTMaccessory").val(),
        }
      },
      props: {
        glasse: {
          type: $(".NTMlunettes").val(),
          alteration: $(".2NTMlunettes").val(),
        },
        ear: {
          type: $(".NTMoreilles").val(),
          alteration: $(".2NTMoreilles").val(),
        },
        hat: {
          type: $(".NTMChoipeaux").val(),
          alteration: $(".2NTMChoipeaux").val(),
        },
        watche: {
          type: $(".NTMWatches").val(),
          alteration: $(".2NTMWatches").val(),
        },
        bracelet: {
          type: $(".NTMbracelets").val(),
          alteration: $(".2NTMbracelets").val(),
        },
      },
    }
      $.post('http://skincreator/updateSkin', JSON.stringify({
        value: val,
        datas: datas,

    }), function(result) {
      reloadThisItems()
    });
  }

  // Form update
  $('input').change(function(){
    loadData(false)
  });

  $('.arrow').on('click', function(e){
    e.preventDefault();
      loadData(false)
  });

  // Form submited
  $('.yes').on('click', function(e){
      e.preventDefault();
      loadData(true)
  });

  // Form submited
  $('.no').on('click', function(e){
    e.preventDefault();
    $.post('http://skincreator/stopEdition', JSON.stringify({
      value: 10
    }));
});

  // Rotate player
  $(document).keypress(function(e) {
    if(e.which == 97){ // A pressed
      $.post('http://skincreator/rotaterightheading', JSON.stringify({
        value: 10
      }));
    }
    if(e.which == 101){ // E pressed
      $.post('http://skincreator/rotateleftheading', JSON.stringify({
        value: 10
      }));
    }
  });

  // Zoom out camera for clothes
  $('.tab a').on('click', function(e){
    $(".block").hide();
    $("." + $(this).attr("to")).show();
    e.preventDefault();
    $.post('http://skincreator/zoom', JSON.stringify({
      zoom: $(this).attr('data-link')
    }));
  });

  // Test value
  var xTriggered = 0;
  $(document).keypress(function(e){
    e.preventDefault();
    xTriggered++;
    if(e.which == 13){
      $.post('http://skincreator/test', JSON.stringify({
        value: xTriggered
      }));
    }
  });

});
