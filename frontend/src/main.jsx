import React from "react";
import ReactDOM from "react-dom/client";
import Feed from "./components/Feed/Feed.jsx";
import Logo from "./components/Logo/Logo.jsx";
import "./index.css";

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <Logo />
    <Feed />
  </React.StrictMode>
);
