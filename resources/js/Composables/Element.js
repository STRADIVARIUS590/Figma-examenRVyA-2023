import { reactive, ref } from "vue";

export default function useInterface() {

    const hexToRgb = (hex) =>{
        var result = hex.match(/.{1,2}/g);

        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16),
        } : {
            r: 0,
            g: 0,
            b : 0,
        }
    }

    const lastIndex = ref(0);

    const mouse = reactive({
        x: 0,
        y: 0,
        relx: 0,
        rely: 0,
        type: 'none',
        selection_index: -1,
        action: 'move',
    })

    const project = ref({
        name: "",
        figures: [],
    });

    const cleanMouseQueue = () =>{
        Object.assign(mouse, 
            {        
                type: 'none',
                action: 'move',
            }
        );
    }

    const selectAction = (type = 'none', action = 'add') =>{
        Object.assign(mouse, 
            {
                type: type,
                selection_index: -1,
                action: action,
            }
        );
    }

    const selectFigure = (index) => {

        var selected_figure = project.value.figures.find((figure) => figure.index == index)

        Object.assign(mouse, 
            {
                type: "none",
                selection_index: index,
                action: "move",
                relx: mouse.x - selected_figure.x,
                rely: mouse.y - selected_figure.y,
            }
        );
    }

    const addElement = (id) => {

        project.value.figures.forEach((figure) => {

            if(lastIndex.value <= figure.index) lastIndex.value = figure.index + 1
        })

        project.value.figures.push({
            index: lastIndex.value,
            type: mouse.type,
            x: mouse.x,
            y: mouse.y,
            h: 50,
            w: 60,
            name: mouse.type + "(" + project.value.figures.length + ")",
            color: "#000000",
            opacity: 100,
            border_size: 2,
            border_color: "#000000",
            border_opacity: 100,
            radius_corner: 0,
            font_size: 25,
            text: "Texto",
            visible: 1,
            deleted: 0,
            draw_id: id,
        });

        cleanMouseQueue();
    }

    const deleteElement = (index) =>{
        let indexFigure = project.value.figures.findIndex(figure => figure.index === index)  
        if(indexFigure >= 0){
            project.value.figures[indexFigure].deleted = 1;
            Object.assign(mouse, 
                {        
                    type: 'none',
                    action: 'move',
                    selection_index: -1,
                }
            );
        }
    }

    const drawFigure = (figure, p) =>{
        if(figure.visible && !figure.deleted){

            if(figure.index == mouse.selection_index){
                p.stroke(0, 0, 200, 1000)
                p.strokeWeight(1);
                p.fill(0,0,0, 0);

                var x,y,x2,y2;

                switch(figure.type){
                    case 'rect': case 'line':
                        x = figure.x - 5
                        y = figure.y - 5
                        x2 = figure.w + 10
                        y2 = figure.h + 10
                        break;
                    case 'ellipse':
                        x = figure.x - figure.w/2 - 5
                        y = figure.y - figure.h/2 - 5
                        x2 = figure.w + 10
                        y2 = figure.h + 10
                        break;
                    case 'text':
                        x = figure.x - 5
                        y = figure.y - figure.font_size
                        x2 = figure.w + 10
                        y2 = figure.h - (figure.font_size/2)
                        break;
                }
                p.rect(x,y,x2,y2);
            }

            //Borde
            var border_color = hexToRgb(figure.border_color);
            p.stroke(border_color.r, border_color.g, border_color.b, figure.border_opacity * 10)
            p.strokeWeight(figure.border_size);
            //Relleno
            var color = hexToRgb(figure.color);
            p.fill(color.r, color.g, color.b, figure.opacity * 10)

            switch(figure.type){
                case 'rect':
                    p.rect(figure.x,figure.y,figure.w,figure.h)
                    break;
                case 'ellipse':
                    p.ellipse(figure.x,figure.y,figure.w,figure.h)
                    break;
                case 'line':
                    p.line(figure.x,figure.y,(figure.x + figure.w),(figure.y + figure.h))
                    break;
                case 'text':
                    p.textSize(figure.font_size);
                    p.text(figure.text,figure.x,figure.y)
                    break;
            }
        }
    }

    return {
        mouse,
        project,
        cleanMouseQueue,
        addElement,
        deleteElement,
        selectAction,
        drawFigure,
        selectFigure,
        lastIndex
    }
}
