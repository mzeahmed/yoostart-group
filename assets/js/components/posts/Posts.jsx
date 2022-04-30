import { __ } from '@wordpress/i18n'
import { YS_GROUP_TEXT_DOMAIN } from '../../constants/constatnts'
import NewPostForm from '../forms/NewPostForm'
import PostHeader from './header/PostHeader'
import moment from 'moment/moment'
import PostContent from './content/PostContent'
import PostFooter from './footer/PostFooter'

const group_id = document.getElementById('group_posts').dataset.groupId
const base_rest_url = window.ys_group_config.rest_url
const groupPostsEndpoint = base_rest_url + 'ys-group/v1/posts?_ys_group_id_meta_key=' + group_id

const { useState, useEffect } = wp.element

/**
 * Affichage des publications
 *
 * @returns {JSX.Element}
 * @constructor
 * @since 1.2.5
 */
function Posts () {
  const [isPending, setIsPending] = useState(false)
  const [error, setError] = useState(null)
  const [posts, setPosts] = useState([])

  useEffect(() => {
    fetch(groupPostsEndpoint)
      .then((res) => {
        if (!res.ok) {
          throw Error(__('Could not fetch the data for that resource', YS_GROUP_TEXT_DOMAIN))
        }
        return res.json()
      })
      .then((data) => {
          setIsPending(true)
          setPosts(data)
          setError(null)
        }
      )
      .catch((error) => {
        setIsPending(true)
        setError(error.message)
      })
  }, [])

  if (error) {
    return (
      <>
        <NewPostForm/>

        <div className="ys-group-posts">
          <p className="post">{__('No post for now', YS_GROUP_TEXT_DOMAIN)}</p>
        </div>
      </>
    )
  } else if (!isPending) {
    return (
      <div className="ys-group-posts-loader text-center">{__('Loading...', YS_GROUP_TEXT_DOMAIN)}</div>
    )
  } else {
    return (
      <div className="ys-group-posts">
        <NewPostForm/>
        {posts.map((post) => (
          <div className="post">
            <PostHeader
              authorAvatar={post.author.avatar_image}
              authorFullname={post.author.fullname}
              postDate={moment(post.date).fromNow()}
              profilUrl={post.author.profile_url}
            />
            <PostContent
              content={post.content}
              postFeaturedImage={post.featured_image.thumbnail}
              postTitle={post.title}
            />
            <PostFooter postId={post.id}/>
          </div>
        ))}
      </div>
    )
  }
}

export default Posts
