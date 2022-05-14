<?php

namespace YsGroup\Services;

/**
 * @since 1.1.7
 */
class Mailer
{
    /**
     * @param string|string[] $to administrateur(s) du group
     * @param string          $requestSenderName
     * @param string          $groupName
     *
     * @return bool|mixed|void
     */
    public function joinGroupRequestMail(array|string $to, string $requestSenderName, string $groupName)
    {
        $message = sprintf(
            __('You have a request by %s to join group: ' . ucfirst('%s')),
            $requestSenderName,
            $groupName
        );

        return wp_mail($to, __('join group request'), $message);
    }
}
