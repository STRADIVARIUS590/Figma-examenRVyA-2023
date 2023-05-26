import { reactive, ref } from "vue";

export default function useInterface() {

    const hexToRgb = (hex) =>{
        var result = hex.slice(1).match(/.{1,2}/g);

        return result ? {
            r: parseInt(result[0], 16),
            g: parseInt(result[1], 16),
            b: parseInt(result[2], 16),
        } : {
            r: 0,
            g: 0,
            b : 0,
        }
    }

    const figureCoords = (figure) => {
        var x,y,x2,y2;

        switch(figure.type){
            case 'rect': case 'line': case'text':
                x = Math.min(figure.x, figure.x + figure.w)
                y = Math.min(figure.y, figure.y + figure.h)
                x2 = Math.abs(figure.w)
                y2 = Math.abs(figure.h)
                break;
            case 'ellipse':
                x = figure.x - Math.abs(figure.w/2)
                y = figure.y - Math.abs(figure.h/2)
                x2 = Math.abs(figure.w)
                y2 = Math.abs(figure.h)
                break;
        }

        return {
            x,y,x2,y2
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
        action: 'none',
    })

    const project = ref({
        name: "",
        figures: [],
    });

    const cleanMouseQueue = () =>{
        Object.assign(mouse, 
            {        
                type: 'none',
                action: 'none',
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

    const clickFigure = () => {

        var selected_figure = -1

        project.value.figures.forEach((figure) => {

            let coords = figureCoords(figure);

            if((mouse.x <= coords.x + coords.x2) && (mouse.x >= coords.x) && 
                (mouse.y <= coords.y + coords.y2) && (mouse.y >= coords.y) && selected_figure < 0){
                selected_figure = figure.index;
            }
        })

        selectFigure(selected_figure, mouse.action);
    }

    const selectFigure = (index, action = "none") => {

        var selected_figure = project.value.figures.find((figure) => figure.index == index)

        Object.assign(mouse, 
            {
                type: "none",
                selection_index: index,
                action: action,
            }
        );
        if(selected_figure){
            Object.assign(mouse, 
                {       
                    relx: mouse.x - selected_figure.x,
                    rely: mouse.y - selected_figure.y,
                }
            );
        }
    }

    const addElement = (id) => {

        project.value.figures.forEach((figure) => {

            if(lastIndex.value <= figure.index) lastIndex.value = figure.index + 1
        })

        project.value.figures.unshift({
            index: lastIndex.value,
            type: mouse.type,
            x: Number(mouse.x?.toFixed(0)),
            y: Number(mouse.y?.toFixed(0)),
            h: 50,
            w: 60,
            name: mouse.type + "(" + project.value.figures.length + ")",
            color: "#FFFFFF",
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

        Object.assign(mouse, 
            {
                type: "none",
                selection_index: lastIndex.value,
                action: "resize",
            }
        );
    }

    const deleteElement = (index) =>{
        let indexFigure = project.value.figures.findIndex(figure => figure.index === index)  
        if(indexFigure >= 0){
            project.value.figures[indexFigure].deleted = 1;
            Object.assign(mouse, 
                {        
                    type: 'none',
                    action: 'none',
                    selection_index: -1,
                }
            );
        }
    }

    const drawFigure = (figure, p) =>{
        if(figure.visible && !figure.deleted){

            if(mouse.selection_index == figure.index && mouse.action == "resize"){
                figure.w = mouse.x - figure.x
                figure.h = mouse.y - figure.y
            }

            if(mouse.selection_index == figure.index && mouse.action == "move"){
                figure.x = mouse.x - mouse.relx;
                figure.y = mouse.y - mouse.rely;
            }

            //Borde
            var border_color = hexToRgb(figure.border_color);
            p.stroke(border_color.r, border_color.g, border_color.b, (figure.border_opacity / 100) * 255)
            p.strokeWeight(figure.border_size);
            //Relleno
            var color = hexToRgb(figure.color);
            p.fill(color.r, color.g, color.b, (figure.opacity / 100 ) * 255)

            switch(figure.type){
                case 'rect':
                    p.rect(figure.x,figure.y,figure.w,figure.h, figure.radius_corner)
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

            if(figure.index == mouse.selection_index){
                p.stroke(0, 0, 200, 255)
                p.strokeWeight(1);
                p.fill(0,0,0, 0);

                let coords = figureCoords(figure)
                p.rect(coords.x - 5, coords.y - 5, coords.x2 + 10, coords.y2 + 10);
            }

        }
    }

    const moveLayer = (index, dir) => {

        let indexFigure = project.value.figures.findIndex(figure => figure.index === index);
        
        let box = project.value.figures[indexFigure];

        project.value.figures[indexFigure] = project.value.figures[indexFigure + dir];

        project.value.figures[indexFigure + dir] = box;

    };

    return {
        mouse,
        project,
        cleanMouseQueue,
        addElement,
        deleteElement,
        selectAction,
        drawFigure,
        selectFigure,
        moveLayer,
        clickFigure,
        figureCoords,
        lastIndex
    }
}
