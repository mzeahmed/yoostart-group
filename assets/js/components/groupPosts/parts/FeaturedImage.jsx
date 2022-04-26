export default function FeaturedImage ({ postFeaturedImage, postTitle }) {
  if (postFeaturedImage) {
    return (
      <div className="featured-image">
        <img src={postFeaturedImage} alt={`Image de ${postTitle}`}/>
      </div>
    );
  }
}