$(document).ready(function(){
    $('#nav-icon3').click(function(){
        $(this).toggleClass('open');

        $('.menu-container').toggleClass('fadeInUp').toggleClass('fadeOutDown').toggle();
        var wall = new freewall("#freewall");
        wall.reset({
            selector: '.brick',
            animate: true,
            cellW: 150,
            cellH: 150,
            delay: 50,
            onResize: function() {
                wall.fitWidth();
                //wall.refresh();
            }
        });
        wall.fitWidth();
    });



    var tabStrip = $("#tabstrip").kendoTabStrip({
        animation:  {
                open: {
                    effects: "fadeIn"
                }
            }
        }).data("kendoTabStrip");

    var openedModules = Array();
    var getItem = function (itemIndex) {
        return tabStrip.tabGroup.children("li").eq(itemIndex);
    }

    function loadContent(itemIndex, content)
    {
        tabStrip.contentElements[itemIndex].innerHTML = content
    }

    function selectTab(itemIndex)
    {
        tabStrip.select(getItem(itemIndex));
    }
  
    function openTab(title, content)
    {
        tabStrip.append({
            text: title,
            content: content,
            imageUrl: "https://cdn3.iconfinder.com/data/icons/fatcow/32/group.png"
        });
    }

    function removeTab(itemIndex)
    {
        var nextIndex = function(index, length) {
          return ((index + 1) % length)
        };

        tabStrip.remove(itemIndex);
        openedModules.splice(itemIndex,1);
        var index = nextIndex(itemIndex, openedModules.length);
        tabStrip.select(index);
        console.log(openedModules);
    }




    $(document).on('click', '.openTab', function(event){
        var module = $(this).data('module');
        var title = $(this).data('title');
        var contentUrl = $(this).attr('href');

        if(jQuery.inArray( module, openedModules ) ==-1)//se nao tiver
        {
            console.log('abrindo')
            $('#previousTab').load(contentUrl,function(data){
                openedModules.push(module)
                openTab(title, data);
                var indexItem = jQuery.inArray( module, openedModules );
                selectTab(indexItem);
                console.log(openedModules)
            });
        }else
        {
            console.log('selecionando ')
            var indexItem = jQuery.inArray( module, openedModules );
            $('#previousTab').load(contentUrl,function(data){
                loadContent(indexItem,data);
                selectTab(indexItem);
                console.log(openedModules)
            });
        }
        if($('#nav-icon3').hasClass('open'))
            $('#nav-icon3').trigger('click');
        
        return false;
    });

    $(document).on('click', '.closeTab', function(event){
        var module = $(this).data('module');
        var indexItem = jQuery.inArray( module, openedModules );
        if(indexItem ==-1)
        {

        }else{
            console.log(indexItem)
            removeTab(indexItem);
        }
       
    })



    $('#previousTab').load(url+'home/page',function(data){
        openTab('Home', data);
        selectTab(0);

    });
});
