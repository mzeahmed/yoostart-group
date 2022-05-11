export default function FeaturedImage ({ postFeaturedImage, postTitle }) {
  if (postFeaturedImage !== false) {
    return (
      <div className="featured-image">
        <img src={postFeaturedImage} alt={`Image de ${postTitle}`}/>
      </div>
    );
  } else {
    return null;
  }
}