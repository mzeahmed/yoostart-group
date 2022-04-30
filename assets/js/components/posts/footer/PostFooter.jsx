import Activities from './parts/Activities'
import Reacts from './parts/Reacts'
import Comment from './parts/Comment'

export default function PostFooter ({ postId }) {
  return (
    <div className="ys-group-post-footer">
      <Activities/>
      <Reacts/>
      <Comment postId={postId}/>
    </div>
  )
}