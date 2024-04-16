import { useState, useEffect } from "react";
import { EffectCoverflow, Pagination, Navigation } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";

import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/pagination";
import "swiper/css/navigation";
import "./Feed.css";

const Feed = () => {
  const [highlights, setHighlights] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(
          "https://localhost:8000/scorebat/highlights/"
        );
        if (response.ok) {
          const jsonData = await response.json();
          setHighlights(jsonData);
        } else {
          console.error("Error in backend request");
        }
      } catch (error) {
        console.error("Error in data fetching:", error);
      }
    };

    fetchData();
  }, []);

  return (
    <Swiper
      modules={[EffectCoverflow, Pagination, Navigation]}
      navigation={{
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        clickable: true,
      }}
      effect={"coverflow"}
      grabCursor={true}
      centeredSlides={true}
      loop={true}
      slidesPerView={"auto"}
      coverflowEffect={{
        rotate: 0,
        stretch: 0,
        depth: 100,
        modifier: 6,
      }}
    >
      {highlights.map((highlight) => (
        <SwiperSlide key={highlight.videos.embed}>
          <div className="card">
            <h2>{highlight.title}</h2>
            <p>{highlight.competition}</p>
            <div
              className="video"
              dangerouslySetInnerHTML={{ __html: highlight.videos.embed }}
            />
          </div>
        </SwiperSlide>
      ))}
      <div className="slider-controler">
        <div className="swiper-button-prev slider-arrow">
          <i className="fa-solid fa-arrow-left-long fa-beat"></i>
        </div>
        <div className="swiper-button-next slider-arrow">
          <i className="fa-solid fa-arrow-right-long fa-beat"></i>
        </div>
      </div>
    </Swiper>
  );
};

export default Feed;
