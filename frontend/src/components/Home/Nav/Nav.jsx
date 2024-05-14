import { Menubar } from "primereact/menubar";

import "primeicons/primeicons.css";
import "./Nav.css";
import { useNavigate } from "react-router-dom";

function Nav() {
  const navigate = useNavigate();
  const handleClickToSignUp = () => navigate("/signup");
  const handleClickToSignIn = () => navigate("/signin");

  const items = [
    {
      label: "Sign In",
      icon: "pi pi-pencil",
      className: "menu-item",
      command: () => handleClickToSignIn(),
    },
    {
      label: "Sign Up",
      icon: "pi pi-pencil",
      className: "menu-item",
      command: () => handleClickToSignUp(),
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
