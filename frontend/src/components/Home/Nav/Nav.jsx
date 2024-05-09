import { Menubar } from "primereact/menubar";

import "primeicons/primeicons.css";
import "./Nav.css";
import { useNavigate } from "react-router-dom";

function Nav() {
  const navigate = useNavigate();
  const handleClick = () => navigate("/signup");

  const items = [
    {
      label: "SignUp",
      icon: "pi pi-pencil",
      className: "menu-item",
      command: () => handleClick(),
    },
  ];

  return (
    <nav>
      <div className="menuBar">
        <Menubar model={items} />
      </div>
    </nav>
  );
}

export default Nav;
