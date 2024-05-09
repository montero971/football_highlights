import { PrimeReactProvider } from "primereact/api";
import Feed from "./Feed/Feed";
import Logo from "./Logo/Logo";
import Nav from "./Nav/Nav";


const Home = () => {
  return (
    <>
      <PrimeReactProvider>
        <Nav />
      </PrimeReactProvider>
      <Logo />
      <Feed />
    </>
  );
};

export default Home;
