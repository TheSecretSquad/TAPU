<?php
foreach($messages as $message) :
	switch($userAccountType) :
	// Current user is player
		case 'P':
		// TP type is to current user
			switch($message['MessageTypeID']) :
				case 'TP': ?>
					<li class="message">
						<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
						<div class="messageCommands">
							<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'A')); ?>" class="messageCommand messageCommandAccept">
								<p class="messageCommandIcon">&#x2714;</p>
							</a>
							<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'D')); ?>" class="messageCommand messageCommandDecline">
								<p class="messageCommandIcon">&#x2716;</p>
							</a>
						</div>
						<p class="messageText">Team <?php echo htmlspecialchars($message['TeamName']); ?> is recruiting you to play <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on their <?php echo $message['SportName']; ?> team.
						</p>
					</li>				
			<?php	break;
				case 'TT': ?>
					<?php switch($message['MessageStateID']) :
							case 'U': ?>
							<li class="message messagePending">
								<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
								<div class="messageCommands">
									<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'C')); ?>" class="messageCommand messageCommandCancelRequest">
										<p class="messageCommandIcon museoTextBold">&#x2716;</p>
									</a>
								</div>
								<p class="messageText">Pending request to <?php echo htmlspecialchars($message['TeamName']); ?> to play <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on their <?php echo $message['SportName']; ?> team.
								</p>
							</li>
					<?php	break;
							case 'A': ?>
								<li class="message messageResult">
									<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
									<div class="messageCommands">
										<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'RA')); ?>" class="messageCommand messageCommandAcknowledge">
											<p class="messageCommandIcon">ok</p>
										</a>
									</div>
									<p class="messageText">Team <?php echo htmlspecialchars($message['TeamName']); ?> <strong class="museoTextBold"><?php echo "accepted"; ?></strong> your request to play <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on their <?php echo $message['SportName']; ?> team!
									</p>
								</li>
						<?php	break;
							case 'D': ?>
								<li class="message messageResult">
									<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
									<div class="messageCommands">
										<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'RA')); ?>" class="messageCommand messageCommandAcknowledge">
											<p class="messageCommandIcon">ok</p>
										</a>
									</div>
									<p class="messageText">Team <?php echo htmlspecialchars($message['TeamName']); ?> <strong class="museoTextBold"><?php echo "declined"; ?></strong> your request to play  <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on their <?php echo $message['SportName']; ?> team.
									</p>
								</li>
						<?php	break;
						endswitch; ?>
			<?php	break;
			endswitch;
			break;
		// Current user is team manager
		case 'M':
			switch($message['MessageTypeID']) :
			// TT type is to current user
				case 'TT': ?>
					<li class="message">
						<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
						<div class="messageCommands">
							<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'A')); ?>" class="messageCommand messageCommandAccept">
								<p class="messageCommandIcon">&#x2714;</p>
							</a>
							<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'D')); ?>" class="messageCommand messageCommandDecline">
								<p class="messageCommandIcon">&#x2716;</p>
							</a>
						</div>
						<p class="messageText"><?php echo htmlspecialchars($message['PlayerName']); ?> is requesting to play <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on your <?php echo $message['SportName']; ?> team, <strong class="museoTextBold"><?php echo $message['TeamName'] ?></strong>.
						</p>
					</li>				
			<?php	break;/* Fix message text! */
				case 'TP': ?>
					<?php switch($message['MessageStateID']) :
							case 'U': ?>
							<li class="message messagePending">
								<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
								<div class="messageCommands">
									<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'C')); ?>" class="messageCommand messageCommandCancelRequest">
										<p class="messageCommandIcon museoTextBold">&#x2716;</p>
									</a>
								</div>
								<p class="messageText">Pending request to <?php echo htmlspecialchars($message['PlayerName']); ?> to play <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on your <?php echo $message['SportName']; ?> team, <strong class="museoTextBold"><?php echo $message['TeamName'] ?></strong>.
								</p>
							</li>
					<?php	break;
							case 'A': ?>
								<li class="message messageResult">
									<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
									<div class="messageCommands">
										<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'RA')); ?>" class="messageCommand messageCommandAcknowledge">
											<p class="messageCommandIcon">ok</p>
										</a>
									</div>
									<p class="messageText"><?php echo htmlspecialchars($message['PlayerName']); ?> <strong class="museoTextBold"><?php echo "accepted"; ?></strong> your request to play <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on your <?php echo $message['SportName']; ?> team, <strong class="museoTextBold"><?php echo $message['TeamName'] ?></strong>.
									</p>
								</li>
						<?php	break;
							case 'D': ?>
								<li class="message messageResult">
									<img class="iconLarge" src="<?php echo !empty($message['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $message['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" />
									<div class="messageCommands">
										<a href="messageAction.php?<?php echo http_build_query(array(Config::PARAM_MSG_ID => $message['MessageID'], Config::PARAM_MSG_ACT => 'RA')); ?>" class="messageCommand messageCommandAcknowledge">
											<p class="messageCommandIcon">ok</p>
										</a>
									</div>
									<p class="messageText"><?php echo htmlspecialchars($message['PlayerName']); ?> <strong class="museoTextBold"><?php echo "declined"; ?></strong> your request to play  <?php echo !empty($message['PositionName']) ? $message['PositionName'] . ' ': ''; ?>on your <?php echo $message['SportName']; ?> team, <strong class="museoTextBold"><?php echo $message['TeamName'] ?></strong>.
									</p>
								</li>
						<?php	break;
						endswitch; ?>
			<?php	break;
			endswitch;
	endswitch;
endforeach;
?>