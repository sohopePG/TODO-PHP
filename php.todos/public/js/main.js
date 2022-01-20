
{
    const checkboxes = document.getElementsByName("checktodo");
    const done_todo = document.getElementsByClassName("done_todo");
    const kesu = document.getElementsByClassName("kesu");
    
    for(let i = 0;i < done_todo.length;i++){
        checkboxes[i].addEventListener("change",()=>{
            done_todo[i].classList.toggle("done");
         })
    }
    
    function deleteTodo(str){
    if(kesu.length == 1){
        if(!confirm(str+"を削除します")){
            return;
        }   
     }else{
         alert("todoが複数個チェックされています")
     }
    }
    
    for(let i = 0;i < kesu.length;i++){
    kesu[i].addEventListener("click",()=>{
        if(done_todo.classList.contains("done")){
            deleteTodo(done_todo.textContent);
        }else{
            return;
        }
     })
}
    
 
}