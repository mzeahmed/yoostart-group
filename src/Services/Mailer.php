<?php

namespace YsGroups\Services;

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
     * @return void
     */
    public function joinGroupRequestMail(array|string $to, string $requestSenderName, string $groupName)
    {
        $message = "You have a request by " . $requestSenderName . " to join group: " . $groupName;

        return wp_mail($to, __('join group request'), $message);
    }
}
