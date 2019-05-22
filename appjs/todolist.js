class todoitem {
  constructor(id, isCompleted, task) {
    this.id = id;
    this.isCompleted = isCompleted;
    this.task = task;
  }
}

class UI {
  static init() {
    if (localStorage.getItem("idTodo") === null) {
      localStorage.setItem("idTodo", 0);
    }
    UI.displayList();
  }
  static updateStatus(completed, total) {
    const statCompleted = document.querySelector(".switchMessage .count");
    statCompleted.innerHTML = `${completed} OUT OF ${total} TASKS COMPLETED`;
  }
  static displayList() {
    // document.querySelector('.item').remove();
    const items = document.querySelectorAll(".item");
    items.forEach(i => i.remove());
    const todoList = Store.getList();
    let totalCompleted = 0;
    todoList.forEach(todo =>
      todo.isCompleted ? totalCompleted++ : totalCompleted
    );
    todoList.forEach(todo => UI.addTaskToList(todo));
    UI.updateStatus(totalCompleted, todoList.length);
    const itemnew = document.querySelectorAll(".item input");
    itemnew.forEach(item =>
      item.addEventListener("click", function(e) {
        let iditem = e.target.parentElement.getAttribute("data-id");
        let checked = e.target.checked;
        Store.changeTask(parseInt(iditem), checked);
        UI.displayList();
      })
    );
  }

  static addTaskToList(todo) {
    const list = document.querySelector(".list");
    const item = document.createElement("div");
    item.className = "item";
    item.setAttribute("data-id", todo.id);
    let checked;
    todo.isCompleted ? (checked = "Checked") : (checked = "");
    item.innerHTML = `
        <input type = "checkbox" "
        id = "task-${todo.id}" ${checked} />
        <label for = "task-${todo.id}" ><span></span>${todo.task}</label>`;

    list.appendChild(item);
  }
}

class Store {
  static getList() {
    let list;
    if (localStorage.getItem("list") === null) {
      list = [];
    } else {
      list = JSON.parse(localStorage.getItem("list"));
      const sortedlist = list
        .sort((a, b) => (a.id < b.id ? 1 : -1))
        .sort((a, b) => (a.isCompleted > b.isCompleted ? 1 : -1));

      list = sortedlist;
    }

    if (list.length == 0) {
      localStorage.setItem("idTodo", 0);
    }

    return list;
  }

  static addList(todotxt) {
    let todo = new todoitem();
    let idtodo = parseInt(localStorage.getItem("idTodo"));
    todo.id = idtodo + 1;
    todo.isCompleted = false;
    todo.task = todotxt;
    const list = Store.getList();
    list.push(todo);
    localStorage.setItem("list", JSON.stringify(list));
    localStorage.setItem("idTodo", todo.id);
  }

  static removeCompleted() {
    let list = Store.getList();
    // const todoinCompleted = list.filter(function (todo) {
    //     return todo.isCompleted === false;
    // });

    //dengan ES6
    const todoinCompleted = list.filter(todo => todo.isCompleted === false);

    localStorage.setItem("list", JSON.stringify(todoinCompleted));
  }
  static changeTask(id, isCompleted) {
    let todoList = Store.getList();
    todoList.forEach((todo, index) => {
      if (todo.id === id) {
        todo.isCompleted = isCompleted;
      }
    });
    // console.log(todoList);
    localStorage.setItem("list", JSON.stringify(todoList));
    //UI.displayList();
  }
}

document.addEventListener("DOMContentLoaded", UI.init());
document.querySelector(".txtAdd").addEventListener("keydown", function(e) {
  if (e.keyCode === 13) {
    Store.addList(this.value);
    this.value = "";
    UI.displayList();
  }
});

document.querySelector(".btnAdd").addEventListener("click", function() {
  swal(
    {
      title: "Are you sure?",
      text: "Do you want to delete all completed task??",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn btn-info btn-fill",
      confirmButtonText: "Yes, delete!",
      cancelButtonClass: "btn btn-danger btn-fill",
      closeOnConfirm: true
    },
    function() {
      Store.removeCompleted();
      UI.displayList();
    }
  );
});
