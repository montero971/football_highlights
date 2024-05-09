import "./Logo.css";
import logo from "/images/logo_football_highlights.svg";

const Logo = () => {
  return (
    <div className="logoContainer">
      <img src={logo} className="appLogo" alt="logo"></img>
    </div>
  );
};

export default Logo;
