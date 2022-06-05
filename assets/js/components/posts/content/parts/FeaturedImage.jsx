export default function FeaturedImage ({ featured_image, title }) {
  if (featured_image !== false) {
    return (
      <div className="featured-image">
        <img src={featured_image} alt={`Image de ${title}`}/>
      </div>
    );
  } else {
    return null;
  }
}