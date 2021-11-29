<!--
<div class="container">
    <div class="row">
        <div class="col-xxl-3 col-xl-2 col-lg-2"></div>
        <div class="col-xxl-6 col-xl-8 col-lg-8 align-self-center">
        -->


<div class="container">
    <div class="col-12 bg-light-- p-5 rounded mx-auto d-block">
        <p class="text-center fs-1">Quem somos</p>
    </div>
    <div class="col-12 bg-light shadow p-5 mb-5">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse semper sodales varius. Pellentesque felis turpis, egestas a mi ut, hendrerit gravida est. Integer nisl nisi, iaculis id mi sit amet, pretium lobortis magna. Etiam et bibendum leo, non molestie ex. Nunc sed lectus eget magna tincidunt ullamcorper in id ante.</p>
        <div class="embed-responsive text-center embed-responsive-16by9">
            <!-- <iframe id='video' -width="1280" -height="720" -width="516" -height="290" src="https://www.youtube.com/watch?v=cZzK32Cfcq8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            <iframe id='video' width="1280" height="720" src="https://www.youtube.com/embed/cZzK32Cfcq8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <p>Cras dictum efficitur mauris, nec faucibus mi luctus sit amet. Integer efficitur nec lacus et consectetur. In consectetur convallis libero quis aliquam. Curabitur consequat, nulla eget accumsan facilisis, ex nunc bibendum nisi, eu finibus ligula libero in nisi. Etiam nec metus tellus. Vestibulum luctus, mi non mollis euismod, leo augue mollis ipsum, et varius nibh sapien vel dui. Donec lacinia semper consequat. Fusce gravida, justo id efficitur tincidunt, odio ligula elementum quam, id molestie justo nulla id nisi. Suspendisse ultricies, lorem nec egestas consectetur, diam sapien scelerisque eros, ut scelerisque arcu quam vitae risus.</p>
        <p>Morbi vulputate est ac commodo vulputate. Fusce est est, rutrum sit amet turpis vitae, faucibus ultricies magna. Quisque venenatis magna congue, tincidunt sem in, iaculis tortor. Ut tincidunt turpis nunc, in eleifend erat faucibus sed. Quisque consectetur dui est, et mollis nunc facilisis id. Quisque sed cursus ligula, quis aliquam odio. Aliquam vestibulum nibh lorem, id sodales mi imperdiet sed.</p>
        <p>Pellentesque ullamcorper tincidunt turpis. Donec ligula sem, hendrerit ut laoreet at, ullamcorper tincidunt felis. Maecenas pretium vitae lectus non semper. Mauris nec maximus orci. Ut bibendum sed velit vitae blandit. Morbi interdum urna in sem finibus rutrum. Cras aliquet nec dolor eu sagittis. Vestibulum luctus, sapien quis aliquam maximus, metus dolor sodales enim, sit amet efficitur massa justo molestie tortor. Duis tempor augue sed pharetra malesuada. Duis at tempus erat. Ut tincidunt dui quis magna hendrerit commodo. Praesent vitae nibh erat. Aliquam dapibus tellus augue, ac congue tortor sodales vitae. Curabitur vestibulum aliquam elit, sagittis ullamcorper tortor fringilla tempor.</p>
        <p>Phasellus congue pretium quam vel luctus. Sed maximus elit quis tempus tristique. Suspendisse interdum efficitur accumsan. Suspendisse non fermentum sapien, nec pharetra enim. Suspendisse finibus molestie fermentum. Quisque a tempus nisl. Sed ut sem mi. Duis posuere, dolor vel venenatis scelerisque, mi turpis iaculis magna, ut cursus ex sapien vel felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut vulputate risus vitae odio pretium, quis mollis elit aliquam. Nulla facilisi. Curabitur eget eros luctus, ornare ligula a, vestibulum nulla. Cras at erat mi. Pellentesque quis velit vel ex condimentum fermentum nec a orci.</p>
    </div>
</div>
<!--
        <div class="col-xxl-3 col-xl-2 col-lg-2"></div>
    </div>
</div>
-->

<script type='text/javascript'>
    // - algumas contas de padaria para definir a escala do vídeo (tomando como padrão que as dimensões são 1280 x 720)
    let video = document.getElementById("video");
    let parent = video.parentElement;
    let bounds = getComputedStyle(parent);
    video.style.width = bounds.width;
    video.style.height = ((parseInt(bounds.width) / 1280) * 720) + 'px';
</script>